<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Notice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard_index()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalNotices = Notice::count();

        // Students with unpaid courses (any course with payment pending)
        $totalUnpaidStudents = Student::whereHas('courses', function ($q) {
            $q->where('course_student.payment', 'pending');
        })->count();

        $recentStudents = Student::latest()->take(3)->get();

        return view('backend.admin.dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalUnpaidStudents',
            'totalNotices',
            'recentStudents'
        ));
    }

    ///Students

     public function students_index(Request $request)
{
    // 1. Start building the Eloquent query, eager loading 'courses'
    $studentsQuery = Student::with('courses');

    // 2. APPLY FILTERING LOGIC

    // Filter by Student Name or Email (live search)
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $studentsQuery->where(function($query) use ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
        });
    }

    // Filter by Class
    if ($request->filled('class')) {
        $studentsQuery->where('class', $request->input('class'));
    }

    // Filter by Payment Status using the 'course_student' pivot table
    if ($request->filled('payment_status')) {
        $status = $request->input('payment_status');
        $studentsQuery->whereHas('courses', function ($query) use ($status) {
            $query->where('course_student.payment', $status);
        });
    }

    // 3. Apply sorting
    $sortBy = $request->input('sort_by', 'id'); // Default: sort by id
    $sortOrder = $request->input('sort_order', 'desc'); // Default: descending (latest first)
    
    // Validate sort parameters
    $allowedSorts = ['id', 'name', 'email', 'class', 'created_at'];
    $allowedOrders = ['asc', 'desc'];
    
    if (!in_array($sortBy, $allowedSorts)) {
        $sortBy = 'id';
    }
    if (!in_array($sortOrder, $allowedOrders)) {
        $sortOrder = 'desc';
    }

    $studentsQuery->orderBy($sortBy, $sortOrder);

    // 4. Get paginated results
    $perPage = $request->input('per_page', 5); // Default: 5 students per page
    $students = $studentsQuery->paginate($perPage)->withQueryString();

    // 5. Get all unique classes for filter dropdown
    $classes = Student::distinct()->pluck('class')->sort()->values();

    // 6. Return the view
    return view('backend.admin.students.index', compact('students', 'classes'));
}

// Add this method for student details modal
public function getStudentDetails($id)
{
    try {
        $student = Student::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'class' => $student->class,
                'phone_number' => $student->phone_number,
                'dob' => $student->dob ? date('F d, Y', strtotime($student->dob)) : null,
                'gender' => $student->gender,
                'blood_group' => $student->blood_group,
                'religion' => $student->religion,
                'father_name' => $student->father_name,
                'father_phone' => $student->father_phone,
                'mother_name' => $student->mother_name,
                'mother_phone' => $student->mother_phone,
                'alt_guardian_name' => $student->alt_guardian_name,
                'alt_guardian_phone' => $student->alt_guardian_phone,
                'present_address' => $student->present_address,
                'permanent_address' => $student->permanent_address,
                'profile_image' => $student->profile_image 
                    ? asset('storage/' . $student->profile_image) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=667eea&color=fff'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to load student details'
        ], 404);
    }
}

// Add this method for courses modal
public function getStudentCourses($id)
{
    try {
        $student = Student::with('courses')->findOrFail($id);
        
        $courses = $student->courses->map(function($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'payment' => $course->pivot->payment,
                'enrollment_date' => $course->pivot->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $student->id,
                'name' => $student->name
            ],
            'courses' => $courses
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to load courses'
        ], 404);
    }
}

    public function create_student()
    {
        // NO LONGER FETCHING COURSES: Courses are now managed separately
        return view('backend.admin.students.create');
    }

    /**
     * Store a newly created student in storage (WITHOUT initial course enrollment).
     * Route: POST /students/store (admin.students.store)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_student(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'nullable|string|min:8',
            'class' => 'required|string|max:50',
            // 'course_ids' and 'payment_status' validation REMOVED
            'phone_number' => 'nullable|string|max:20',
            // NEW FIELDS (all nullable)
        'father_name' => 'nullable|string|max:255',
        'father_phone' => 'nullable|string|max:20',
        'mother_name' => 'nullable|string|max:255',
        'mother_phone' => 'nullable|string|max:20',
        'alt_guardian_name' => 'nullable|string|max:255',
        'alt_guardian_phone' => 'nullable|string|max:20',
        'blood_group' => 'nullable|string|max:5',
        'religion' => 'nullable|string|max:50',
        'gender' => 'nullable|in:male,female,other',
        'present_address' => 'nullable|string',
        'permanent_address' => 'nullable|string',
      
        ]);

        // 2. Prepare student data
    $studentData = $request->only([
        'name', 'email', 'class', 'phone_number',
        'father_name', 'father_phone', 'mother_name', 'mother_phone',
        'alt_guardian_name', 'alt_guardian_phone', 'blood_group',
        'religion', 'gender', 'present_address', 'permanent_address'
        
    ]);

        // Hash the password (using email as default if password is not provided)
        $studentData['password'] = Hash::make($request->password ?? $request->email);

        // 3. Create the student record
        $student = Student::create($studentData);

        // 4. Course Enrollment Logic REMOVED

        return redirect()->route('admin.students')->with(
            'success',
            'Student ' . $student->name . ' successfully registered.' // Updated success message
        );
    }

    /**
     * Show the form for editing the specified student (Course management is kept here).
     * Route: GET /students/edit/{student} (admin.students.edit)
     *
     * @param  \App\Models\Student  $student (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function edit_student(Student $student)
    {
        // Fetch all courses for the form options (Still needed for the EDIT form)
        $courses = Course::all();

        // Get the IDs of the courses the student is currently enrolled in
        $enrolledCourseIds = $student->courses->pluck('id')->toArray();

        // This view is the one you provided in the query, requiring $courses, $student, and $enrolledCourseIds.
        return view('backend.admin.students.edit', compact('student', 'courses', 'enrolledCourseIds'));
    }

    /**
     * Update the specified student in storage (Course management is kept here).
     * Route: PUT /students/update/{student} (admin.students.update)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_student(Request $request, Student $student)
    {
        // 1. Validation (Matches store_student, but includes unique rule for update)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Rule::unique ignores the current student's email to allow updates
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'password' => 'nullable|string|min:8',
            'class' => 'required|string|max:50',
            // 'course_ids' and 'payment_status' validation REMOVED
            'phone_number' => 'nullable|string|max:20',
            // NEW FIELDS (nullable)
        'father_name' => 'nullable|string|max:255',
        'father_phone' => 'nullable|string|max:20',
        'mother_name' => 'nullable|string|max:255',
        'mother_phone' => 'nullable|string|max:20',
        'alt_guardian_name' => 'nullable|string|max:255',
        'alt_guardian_phone' => 'nullable|string|max:20',
        'blood_group' => 'nullable|string|max:5',
        'religion' => 'nullable|string|max:50',
        'gender' => 'nullable|in:male,female,other',
        'present_address' => 'nullable|string',
        'permanent_address' => 'nullable|string',

        ]);

        // 2. Prepare student data
    $studentData = $request->only([
        'name', 'email', 'class', 'phone_number',
        'father_name', 'father_phone', 'mother_name', 'mother_phone',
        'alt_guardian_name', 'alt_guardian_phone', 'blood_group',
        'religion', 'gender', 'present_address', 'permanent_address'
    ]);

        // Handle password update only if a new password was explicitly provided.
        // NOTE: We do NOT use the 'email as default password' logic from store, 
        // as that is only appropriate for initial creation, not updating existing users.
        if (!empty($request->password)) {
            $studentData['password'] = Hash::make($request->password);
        }
        // If the password field is null/empty, we intentionally don't add 'password' to $studentData, 
        // thus preserving the existing hashed password.

        // 3. Update the student record
        $student->update($studentData);

        // 4. Course Enrollment Logic REMOVED to match store_student

        return redirect()->route('admin.students')->with(
            'success',
            'Student ' . $student->name . ' updated successfully.' // Simplified success message
        );
    }
    /**
     * Remove the specified student from storage.
     */
    public function destroy_student(Student $student)
    {
        $studentName = $student->name;
        $student->delete();

        return redirect()->route('admin.students')->with(
            'danger',
            'Student ' . $studentName . ' and all related course enrollments have been deleted.'
        );
    }





    public function updatePayment(Request $request, $studentId, $courseId)
    {
        // Validate allowed statuses — match your pivot enum exactly
        $validated = $request->validate([
            'payment_status' => 'required|string|in:pending,done',
        ]);

        try {
            $student = Student::findOrFail($studentId);

            // Ensure the student is enrolled in that course
            $hasCourse = $student->courses()->where('course_id', $courseId)->exists();

            if (!$hasCourse) {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is not assigned to the student.',
                ], 404);
            }

            // Update pivot
            $student->courses()->updateExistingPivot($courseId, [
                'payment' => $validated['payment_status'],
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated.',
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error while updating payment.',
            ], 500);
        }
    }
    // Courses
    public function courses_index()
    {
        $courses = Course::latest()->paginate(10);
        return view('backend.admin.courses.index', compact('courses'));
    }


    public function create_course()
    {
        return view('backend.admin.courses.courses_create');
    }


    public function store_course(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150|unique:courses,title',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instructor' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'lectures_count' => 'nullable|integer|min:0',
            'duration' => 'nullable|string|max:50',
            'skill_level' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'fee' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'offer_expires_at' => 'nullable|date',
        ]);

        $data = $request->only([
            'title',
            'description',
            'instructor',
            'rating',
            'reviews',
            'lectures_count',
            'duration',
            'skill_level',
            'language',
            'fee',
            'offer_price',
            'offer_expires_at'
        ]);

        // Handle image upload correctly
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('courses', $filename, 'public');
            $data['image'] = $path; // save the path in DB
        }

        Course::create($data);

        return redirect()->route('admin.courses')
            ->with('success', 'Course created successfully.');
    }



    public function edit_course(Course $course)
    {
        return view('backend.admin.courses.courses_edit', compact('course'));
    }


    public function update_course(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:150|unique:courses,title,' . $course->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'instructor' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'lectures_count' => 'nullable|integer|min:0',
            'duration' => 'nullable|string|max:50',
            'skill_level' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'fee' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'offer_expires_at' => 'nullable|date',
        ]);

        $data = $request->only([
            'title',
            'description',
            'instructor',
            'rating',
            'reviews',
            'lectures_count',
            'duration',
            'skill_level',
            'language',
            'fee',
            'offer_price',
            'offer_expires_at'
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['image'] = $file->storeAs('courses', $filename, 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses')
            ->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function destroy_course(Course $course)
    {
        // Delete image from storage
        if ($course->image && Storage::disk('public')->exists($course->image)) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses')
            ->with('danger', 'Course deleted successfully.');
    }



    ///Students


    public function lectures_index_all()
    {
        $courses = Course::with('lectures')->get();
        return view('backend.admin.lectures.index', compact('courses'));

    }

    public function getLecturesByCourse(Course $course)
    {
        // Eager load lectures sorted by order or creation date
        $lectures = $course->lectures()
            ->orderBy('order', 'asc') // Assuming you want them by the 'order' field
            ->get();

        // Check if it's an AJAX request (best practice)
        if (request()->ajax()) {
            // Return the partial view containing the table HTML
            return view('backend.admin.lectures.lectures_table', compact('lectures'))->render();
        }

        // Optional: Redirect if accessed directly (not via AJAX)
        return redirect()->route('admin.lectures.index')->with('danger', 'Invalid access method.');
    }

    /**
     * 2. CREATE: Show a form for creating a new lecture.
     * Requires the admin to select a Course from a dropdown, as the route is flat.
     * Route: GET /admin/lectures/create (admin.lectures.create)
     */
    public function create_lecture_select_course()
    {
        // Pass all courses to the view for the selection dropdown
        $courses = Course::pluck('title', 'id');

        // Assumes the view path is: resources/views/backend/admin/lectures/create.blade.php
        return view('backend.admin.lectures.create', compact('courses'));
    }

    /**
     * 3. STORE: Handles storing the new lecture, linked via the selected course_id.
     * Route: POST /admin/lectures/store (admin.lectures.store)
     */
    public function store_lecture_all(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id', // Mandatory course selection
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(['pre_recorded', 'live'])],
            'youtube_link' => 'required|url',
            // live_scheduled_at is required only if type is 'live'
            'live_scheduled_at' => 'nullable|date_format:Y-m-d\TH:i|required_if:type,live',
            'order' => 'required|integer|min:0',
        ]);

        // Clean up data for pre-recorded lectures
        if ($validatedData['type'] === 'pre_recorded') {
            $validatedData['live_scheduled_at'] = null;
        }

        Lecture::create($validatedData);

        // Redirects back to the centralized index page
        return redirect()->route('admin.lectures.index')
            ->with('success', 'Lecture created successfully.');
    }

    /**
     * 4. EDIT: Show edit form for an existing lecture.
     * Route: GET /admin/lectures/edit/{lecture} (admin.lectures.edit)
     */
    public function edit_lecture(Lecture $lecture)
    {
        // Pass all courses (for the dropdown to change the lecture's parent course)
        $courses = Course::pluck('title', 'id');

        // Assumes the view path is: resources/views/backend/admin/lectures/edit.blade.php
        return view('backend.admin.lectures.edit', compact('lecture', 'courses'));
    }

    /**
     * 5. UPDATE: Update an existing lecture.
     * Route: POST /admin/lectures/update/{lecture} (admin.lectures.update)
     */
    public function update_lecture(Request $request, Lecture $lecture)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id', // Course selection (allows moving lecture)
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::in(['pre_recorded', 'live'])],
            'youtube_link' => 'required|url',
            'live_scheduled_at' => 'nullable|date_format:Y-m-d\TH:i|required_if:type,live',
            'order' => 'required|integer|min:0',
        ]);

        if ($validatedData['type'] === 'pre_recorded') {
            $validatedData['live_scheduled_at'] = null;
        }

        $lecture->update($validatedData);

        // Redirects back to the centralized index page
        return redirect()->route('admin.lectures.index')
            ->with('success', 'Lecture updated successfully.');
    }

    /**
     * 6. DELETE: Delete a lecture.
     * Route: DELETE /admin/lectures/delete/{lecture} (admin.lectures.destroy)
     */
    public function destroy_lecture(Lecture $lecture)
    {
        $lecture->delete();

        // Redirects back to the centralized index page
        return redirect()->route('admin.lectures.index')
            ->with('danger', 'Lecture deleted successfully.');
    }




    public function notice_index()
    {
        $notices = Notice::latest()->paginate(10);
        return view('backend.admin.notices.index', compact('notices'));
    }

    public function notice_create()
    {
        $courses = Course::all();
        $students = Student::all();
        return view('backend.admin.notices.create', compact('courses', 'students'));
    }


    public function notice_store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'target_type' => 'required|in:all,course,student',
            'target_course_id' => 'nullable|integer|exists:courses,id',
            'target_student_id' => 'nullable|integer|exists:students,id',
            'is_active' => 'boolean',
        ]);

        // Determine the correct target_id based on target_type
        $validated['target_id'] = match ($validated['target_type']) {
            'course' => $validated['target_course_id'],
            'student' => $validated['target_student_id'],
            default => null,
        };

        // Clean up extra fields
        unset($validated['target_course_id'], $validated['target_student_id']);

        Notice::create($validated);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }


    public function notice_edit(Notice $notice)
    {
        $courses = Course::all();
        $students = Student::all();

        return view('backend.admin.notices.edit', compact('notice', 'courses', 'students'));
    }


    public function notice_update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'target_type' => 'required|in:all,course,student',
            'target_course_id' => 'nullable|integer|exists:courses,id',
            'target_student_id' => 'nullable|integer|exists:students,id',
            'is_active' => 'boolean',
        ]);

        $validated['target_id'] = match ($validated['target_type']) {
            'course' => $validated['target_course_id'],
            'student' => $validated['target_student_id'],
            default => null,
        };

        unset($validated['target_course_id'], $validated['target_student_id']);

        $notice->update($validated);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function notice_destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted.');
    }


}

