<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('frontend.pages.index');
});

///Frontend Routes:
Route::get('/', [CourseController::class, 'home'])->name('home');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.detail');
Route::get('/courses/search', [CourseController::class, 'liveSearch'])->name('courses.search');



// Student/Admin login portal
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Student registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Logout (available to authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin dashboard (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard_index'])->name('admin.dashboard');
    // Students Crud
    Route::get('/students', [AdminController::class, 'students_index'])->name('admin.students');
    Route::get('/students/create', [AdminController::class, 'create_student'])->name('admin.students.create');
    Route::post('/students/store', [AdminController::class, 'store_student'])->name('admin.students.store');
    Route::get('/students/edit/{student}', [AdminController::class, 'edit_student'])->name('admin.students.edit');
    Route::put('students/update/{student}', [AdminController::class, 'update_student'])->name('admin.students.update');
    Route::delete('/students/delete/{student}', [AdminController::class, 'destroy_student'])->name('admin.students.destroy');
    Route::post('/students/{student}/courses/{course}/update-payment', [AdminController::class, 'updatePayment'])
        ->name('admin.students.updatePayment');

    // Student Detail & Course Modals (AJAX endpoints)
    // AJAX Routes for Student Details and Courses
Route::get('/students/{id}/details', [AdminController::class, 'getStudentDetails']);
Route::get('/students/{id}/courses', [AdminController::class, 'getStudentCourses']);
Route::post('/students/{studentId}/courses/{courseId}/update-payment', [AdminController::class, 'updatePaymentStatus']);
    
    // Courses CRUD
    Route::get('/courses', [AdminController::class, 'courses_index'])->name('admin.courses');
    Route::get('/courses/create', [AdminController::class, 'create_course'])->name('admin.courses.create');
    Route::post('/courses/store', [AdminController::class, 'store_course'])->name('admin.courses.store');
    Route::get('/courses/edit/{course}', [AdminController::class, 'edit_course'])->name('admin.courses.edit');
    Route::post('/courses/update/{course}', [AdminController::class, 'update_course'])->name('admin.courses.update');
    Route::delete('/courses/delete/{course}', [AdminController::class, 'destroy_course'])->name('admin.courses.destroy');
    // LECTURES Crud
    Route::get('/lectures', [AdminController::class, 'lectures_index_all'])->name('admin.lectures.index');
    Route::get('lectures/by-course/{course}', [AdminController::class, 'getLecturesByCourse'])->name('admin.lectures.by_course');
    Route::get('/lectures/create', [AdminController::class, 'create_lecture_select_course'])->name('admin.lectures.create');
    Route::post('/lectures/store', [AdminController::class, 'store_lecture_all'])->name('admin.lectures.store');
    Route::get('/lectures/edit/{lecture}', [AdminController::class, 'edit_lecture'])->name('admin.lectures.edit');
    Route::put('/lectures/update/{lecture}', [AdminController::class, 'update_lecture'])->name('admin.lectures.update');
    Route::delete('/lectures/delete/{lecture}', [AdminController::class, 'destroy_lecture'])->name('admin.lectures.destroy');
    // Notices Crud
    Route::get('/notices', [AdminController::class, 'notice_index'])->name('admin.notices.index');
    Route::get('/notices/create', [AdminController::class, 'notice_create'])->name('admin.notices.create');
    Route::post('/notices/store', [AdminController::class, 'notice_store'])->name('admin.notices.store');
    Route::get('/notices/{notice}/edit', [AdminController::class, 'notice_edit'])->name('admin.notices.edit');
    Route::put('/notices/{notice}/update', [AdminController::class, 'notice_update'])->name('admin.notices.update');
    Route::delete('/notices/{notice}/destroy', [AdminController::class, 'notice_destroy'])->name('admin.notices.destroy');


});




// Student routes (protected by student guard)
Route::middleware('auth:student')->group(function () {

    Route::prefix('student')->name('student.')->group(function () {
        ///Dashboard
        Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        //My Profile
        Route::get('profile', [StudentController::class, 'profile'])->name('profile');
        Route::get('profile/edit', [StudentController::class, 'edit_profile'])->name('profile.edit');
        Route::put('profile', [StudentController::class, 'update_profile'])->name('profile.update');
        // My Courses
        Route::get('courses', [StudentController::class, 'indexCourses'])->name('courses');
        Route::get('courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
        //My Notices

        Route::get('/notices', [StudentController::class, 'notices_index'])->name('notices');


    });

});