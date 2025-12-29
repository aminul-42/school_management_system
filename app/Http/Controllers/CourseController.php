<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Home page with courses
    public function home()
    {
        $courses = Course::all(); // load all courses
        return view('frontend.pages.index', compact('courses'));
    }

    // Show a single course detail

public function show($id)
{
    $course = Course::findOrFail($id);

    $relatedCourses = Course::where('language', $course->language)
                            ->where('id', '!=', $course->id)
                            ->get();

    $allCourses = Course::all(); // for dropdown

    return view('frontend.pages.course_details', compact('course', 'relatedCourses', 'allCourses'));
}


public function liveSearch(Request $request) {
    $query = $request->get('query');
    $courses = Course::where('title', 'like', "%{$query}%")
                     ->orWhere('language', 'like', "%{$query}%")
                     ->orWhere('instructor', 'like', "%{$query}%")
                     ->get(['id', 'title', 'language', 'instructor']);
    return response()->json($courses);
}


}
