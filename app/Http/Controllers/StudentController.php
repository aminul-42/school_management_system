<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Notice;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class StudentController extends Controller
{
    public function dashboard()
{
    $student = Auth::guard('student')->user();

    // --- 1. Get Paid Courses ---
    $paidCourses = $student->courses()
        ->wherePivot('payment', 'done')
        ->with('lectures')
        ->get();

    // --- 2. Get Active Notices ---
    $enrolledCourseIds = $student->courses()->pluck('course_id');

    $notices = Notice::where('is_active', true)
        ->where(function ($query) use ($student, $enrolledCourseIds) {
            $query->where('target_type', 'all')
                ->orWhere(function ($q) use ($student) {
                    $q->where('target_type', 'student')->where('target_id', $student->id);
                })
                ->orWhere(function ($q) use ($enrolledCourseIds) {
                    $q->where('target_type', 'course')->whereIn('target_id', $enrolledCourseIds);
                });
        })
        ->latest()
        ->take(5) // Show latest 5 notices
        ->get();

    // --- 3. Live Classes (if lecture type = live) ---
    $liveLectures = $paidCourses->flatMap(function ($course) {
        return $course->lectures->where('type', 'live');
    })->take(5);

    return view('backend.student.dashboard', compact('paidCourses', 'notices', 'liveLectures'));
}



    public function profile()
    {
        // Get the currently logged-in student using the student guard
        $student = auth()->guard('student')->user();

        // Pass student data to the view
        return view('backend.student.profile.profile', compact('student'));
    }

    /**
     * Show the form for editing the student's own profile.
     * CRITICAL: Do NOT rely on route model binding for security.
     */
    public function edit_profile()
    {
        // Security: Ensure the student can ONLY edit their OWN profile
        $student = auth()->guard('student')->user();

        // Get all courses (including IDs)
        $allCourses = Course::all();

        // Get the IDs of the courses the student is currently enrolled in
        $enrolledCourseIds = $student->courses()->pluck('course_id')->toArray();

        return view('backend.student.profile.edit', compact('student', 'allCourses', 'enrolledCourseIds'));
    }

    /**
     * Update the student's own profile and course enrollments.
     * CRITICAL: Do NOT rely on route model binding for security.
     */
    public function update_profile(Request $request)
    {
        // CRITICAL SECURITY FIX: Get the authenticated student directly.
        $student = auth()->guard('student')->user();

        // 1. Validation for Student's personal details and new fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'class' => 'required|string|max:50',
            'phone_number' => 'nullable|string|max:20',
            // New validation for password
            'password' => 'nullable|string|min:8|confirmed',
            // Profile image validation (using profile_image to match migration)
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            // Validation for course enrollment changes
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:courses,id',
            // New fields
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

        // 2. Prepare Data for Update
       $data = $request->only([
    'name', 'email', 'class', 'phone_number',
    'father_name', 'father_phone', 'mother_name', 'mother_phone',
    'alt_guardian_name', 'alt_guardian_phone', 'blood_group', 'religion',
    'gender', 'present_address', 'permanent_address'
]);

        // Handle Password Update (Only if provided)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Handle Profile Picture Upload (If a file is provided)
        if ($request->hasFile('profile_image')) {
            // Delete old picture if it exists
            if ($student->profile_image) {
                // Use the correct column name: profile_image
                Storage::disk('public')->delete($student->profile_image);
            }

            // Store the new file and save its path
            // The file is stored in storage/app/public/profiles/students
            $path = $request->file('profile_image')->store('profiles/students', 'public');
            $data['profile_image'] = $path; // Use the correct column name: profile_image
        }

        // 3. Update Student's primary data
        $student->update($data);

        // 4. Update the Courses via the Pivot Table (Maintaining payment status)
        $selectedCourseIds = $request->input('course_ids', []);
        $syncData = [];

        // Loop through the selected courses to determine the correct payment status
        // IMPORTANT: The pivot relationship is loaded dynamically by the first() call or explicitly loaded if needed.
        foreach ($selectedCourseIds as $courseId) {
            // Find the existing pivot relationship if it exists
            // We need to use 'wherePivot' if we haven't loaded the relationship yet and are filtering on the pivot
            $oldEnrollment = $student->courses()->where('course_id', $courseId)->first();

            // Determine payment status: keep old status if enrolled, otherwise default to 'pending'
            $paymentStatus = $oldEnrollment && $oldEnrollment->pivot ? $oldEnrollment->pivot->payment : 'pending';

            $syncData[$courseId] = ['payment' => $paymentStatus];
        }

        // Sync detaches removed courses, and attaches/updates remaining courses while preserving the 'payment' pivot field.
        $student->courses()->sync($syncData);

        return redirect()->route('student.profile')->with('success', 'Your profile and course enrollments have been updated successfully. ✅');
    }

    ///Courses Crud


    public function indexCourses()
    {
        // 1. Get the currently authenticated student
        $student = Auth::guard('student')->user();

        // 2. Load all enrolled courses, including the 'payment' field from the pivot table
        // CRITICAL: Eager load the 'lectures' relationship
        $enrolledCourses = $student->courses()->withPivot('payment')->with('lectures')->get();

        // 3. Categorize the enrolled courses based on the pivot table's 'payment' status
        $pendingCourses = $enrolledCourses->filter(function ($course) {
            return $course->pivot->payment !== 'done';
        });
        $paidCourses = $enrolledCourses->filter(function ($course) {
            return $course->pivot->payment === 'done';
        });

        return view('backend.student.courses.index', [
            'pendingCourses' => $pendingCourses,
            'paidCourses' => $paidCourses,
        ]);
    }


    public function showCourse(Course $course, Request $request)
    {
        $student = Auth::guard('student')->user();

        // Ensure student is enrolled and paid
        $enrolledCourse = $student->courses()
            ->where('course_id', $course->id)
            ->withPivot('payment')
            ->first();

        if (!$enrolledCourse) {
            return redirect()->route('student.courses')
                ->with('danger', 'You are not enrolled in this course.');
        }

        if ($enrolledCourse->pivot->payment !== 'done') {
            return redirect()->route('student.courses')
                ->with('warning', 'Payment pending. Complete payment to access lectures.');
        }

        // Load lectures
        $enrolledCourse->load(['lectures' => fn($q) => $q->orderBy('order', 'asc')]);

        // Separate playlists
        $prerecordedLectures = $enrolledCourse->lectures->where('type', 'pre_recorded');
        $liveLectures = $enrolledCourse->lectures->where('type', 'live');

        // Determine current lecture
        $currentLectureId = $request->query('lecture');
        $currentLecture = $currentLectureId
            ? $enrolledCourse->lectures->firstWhere('id', $currentLectureId)
            : $prerecordedLectures->first() ?? $liveLectures->first();

        return view('backend.student.courses.show', [
            'course' => $enrolledCourse,
            'prerecordedLectures' => $prerecordedLectures,
            'liveLectures' => $liveLectures,
            'currentLecture' => $currentLecture,
        ]);

    }


    public function notices_index()
    {
        // 1. Get the currently authenticated student
        $student = Auth::guard('student')->user();

        // 2. Get the IDs of the courses the student is enrolled in
        // This leverages the courses() relationship defined in your Student model.
        $enrolledCourseIds = $student->courses()->pluck('course_id');

        // 3. Query for relevant notices:
        $notices = Notice::where('is_active', true) // Only show active notices
            ->where(function ($query) use ($student, $enrolledCourseIds) {

                // Condition A: Notices targeted to 'all' users
                $query->where('target_type', 'all')
                    ->whereNull('target_id'); // Ensure target_id is null for 'all'
    
                // Condition B: Notices targeted to this specific 'student'
                $query->orWhere(function ($q) use ($student) {
                    $q->where('target_type', 'student')
                        ->where('target_id', $student->id);
                });

                // Condition C: Notices targeted to one of the student's enrolled 'course's
                if ($enrolledCourseIds->isNotEmpty()) {
                    $query->orWhere(function ($q) use ($enrolledCourseIds) {
                        $q->where('target_type', 'course')
                            ->whereIn('target_id', $enrolledCourseIds);
                    });
                }
            })
            ->latest() // Order by creation date descending (newest first)
            ->paginate(10); // Paginate the results

        // 4. Return the view with the filtered notices
        return view('backend.student.notices.index', compact('notices'));
    }

}