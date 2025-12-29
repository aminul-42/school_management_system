<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLectureAccess
{

    public function handle(Request $request, Closure $next)
    {
        // 1. Get the lecture and its course
        $lecture = $request->route('lecture');
        $course = $lecture->course;

        // 2. Get the authenticated student
        $student = auth('student')->user();

        // 3. Check enrollment and payment status
        $enrollment = $student->courses()
            ->where('course_id', $course->id)
            ->first();

        // Check 1: Is the student even enrolled?
        if (!$enrollment) {
            return redirect()->route('student.dashboard')
                ->with('error', 'You are not enrolled in this course.');
        }

        // Check 2: Is the payment complete? (Assumes 'payment' column in pivot)
        if ($enrollment->pivot->payment !== 'paid') {
            return redirect()->route('payment.show', $course->id)
                ->with('error', 'Please complete your payment to view this lecture.');
        }

        // Access granted
        return $next($request);
    }
}