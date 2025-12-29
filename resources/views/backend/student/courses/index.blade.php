@extends('backend.student.layouts.app')

@section('title', 'My Courses')

@push('styles')
<style>
    /* --- Course Page Specific Styles --- */

    .course-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .course-item {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Lighter shadow for modern feel */
        border: 1px solid #e0eaf6; /* Light border */
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .course-item:hover {
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* Course Header (Container for main info) */
    .course-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 25px;
        background: #fff;
        border-bottom: 2px solid var(--primary-blue);
    }

    .course-header.pending {
        background: #f7f7f7;
        border-bottom: 2px solid var(--danger); /* Highlight pending with danger color */
    }
    
    .course-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-grow: 1;
    }

    .course-info i {
        font-size: 1.8rem; /* Slightly larger icon */
        color: var(--primary-blue);
    }
    
    .course-header.pending .course-info i {
        color: var(--danger);
    }

    .course-title {
        font-size: 1.35rem; /* Slightly larger title */
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }
    
    .course-header.pending .course-title {
        color: #777;
    }

    /* Progress and Status */
    .course-progress-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .course-progress-bar {
        width: 150px;
        min-width: 150px;
        height: 8px; /* Slightly thinner bar */
        background: #e0e0e0;
        border-radius: 4px;
    }
    
    .progress-fill-course {
        height: 100%;
        background: var(--success);
        border-radius: 4px;
        transition: width 0.5s ease-out;
    }
    
    .progress-fill-pending {
        background: var(--danger);
    }

    .course-status {
        font-weight: 600;
        color: var(--primary-blue);
        min-width: 100px;
        text-align: right;
    }
    .status-pending-text {
        color: var(--danger);
    }
    .status-paid-text {
        color: var(--success); /* Use success for complete status */
    }

    /* Action Button Area - NEW */
    .course-action {
        padding: 15px 25px;
        border-top: 1px solid #f0f0f0;
        text-align: right;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    
    .course-action.pending {
        background: #fffafa; /* Light red background for pending action */
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: var(--radius);
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    }

    .action-button.paid {
        background-color: var(--primary-blue);
        color: var(--white);
    }
    .action-button.paid:hover {
        background-color: green;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    
    .action-button.pending-btn {
        background-color: var(--danger);
        color: var(--white);
    }
    .action-button.pending-btn:hover {
        background-color: #c9302c; /* Darker red */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .action-button i {
        margin-left: 10px;
    }
    
    /* Mobile adjustments */
    @media (max-width: 768px) {
        .course-header {
            flex-wrap: wrap;
            padding: 15px;
        }
        .course-info {
            width: 100%;
            margin-bottom: 10px;
        }
        .course-title {
            font-size: 1.2rem;
        }
        .course-progress-container {
            width: 100%;
            justify-content: space-between;
        }
        .course-progress-bar {
            width: 50%;
            min-width: unset;
        }
        .course-status {
            min-width: unset;
            text-align: left;
            font-size: 0.9rem;
        }
        .course-action {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
    <div class="mb-8">
        <h2 style="color: var(--primary-dark);" class="text-3xl font-extrabold mb-1">Your Active Learning Journey</h2>
       
    </div>

    <div class="course-container" id="courseContainer">
        
        <h3 style="color: var(--primary-blue);" class="text-xl font-bold mt-4 mb-2">Paid & Enrolled Courses ({{ $paidCourses->count() }})</h3>
        
        @forelse ($paidCourses as $course)
            @php
                // Mock Logic for Demo: Calculate Progress
                $totalLectures = $course->lectures->count();
                $mockCompleted = $totalLectures > 0 ? (
                    ($totalLectures % 2 === 0) ? floor($totalLectures / 2) : floor($totalLectures / 3)
                ) : 0;
                $progressPercentage = $totalLectures > 0 ? round(($mockCompleted / $totalLectures) * 100) : 0;
                $courseIdSlug = \Illuminate\Support\Str::slug($course->title . '-' . $course->id);
            @endphp
            <div class="course-item">
                <div class="course-header" data-course="{{ $courseIdSlug }}">
                    <div class="course-info">
                        <i class="fa fa-book"></i>
                        <h3 class="course-title">{{ $course->title }}</h3>
                    </div>
                    <div class="course-progress-container">
                        <div class="course-progress-bar">
                            <div class="progress-fill-course" style="width: {{ $progressPercentage }}%;"></div>
                        </div>
                        <div class="course-status status-paid-text">{{ $progressPercentage }}% Complete</div>
                    </div>
                </div>
                
                {{-- REPLACED ACCORDION LECTURE LIST with a BUTTON --}}
                <div class="course-action">
                    {{-- Assuming 'student.courses.show' takes the course ID as a parameter --}}
                    <a href="{{ route('student.courses.show', ['course' => $course->id]) }}" class="action-button paid">
                        All Lectures <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center p-6 bg-white rounded-lg shadow-inner">
                <i class="fa fa-graduation-cap text-5xl text-gray-300 mb-3"></i>
                <p class="text-gray-600 font-medium">You haven't enrolled in any paid courses yet. Time to start learning!</p>
            </div>
        @endforelse

        <h3 style="color: var(--danger);" class="text-xl font-bold mt-6 mb-2">Payment Pending ({{ $pendingCourses->count() }})</h3>

        @forelse ($pendingCourses as $course)
            @php
                $courseIdSlug = \Illuminate\Support\Str::slug($course->title . '-' . $course->id);
            @endphp
            <div class="course-item">
                {{-- Add the 'pending' class and show a lock icon --}}
                <div class="course-header pending" data-course="{{ $courseIdSlug }}">
                    <div class="course-info">
                        <i class="fa fa-money-bill-alt"></i>
                        <h3 class="course-title">{{ $course->title }}</h3>
                    </div>
                    <div class="course-progress-container">
                        <div class="course-progress-bar">
                            <div class="progress-fill-course progress-fill-pending" style="width: 100%;"></div>
                        </div>
                        <div class="course-status status-pending-text">Payment Pending</div>
                    </div>
                </div>
                
                {{-- Action is the 'Proceed to Payment' button --}}
                <div class="course-action pending">
                    {{-- Placeholder link for payment route, you should update this --}}
                    <a href="#" class="action-button pending-btn">
                        <i class="fa fa-credit-card mr-2"></i> Complete Payment
                    </a> 
                </div>
            </div>
        @empty
            <div class="text-center p-6 bg-white rounded-lg shadow-inner">
                <i class="fa fa-check-circle text-5xl text-success mb-3"></i>
                <p class="text-gray-600 font-medium">Excellent! All your enrolled courses are paid for and ready to go.</p>
            </div>
        @endforelse
        
    </div>
@endsection

@push('scripts')
{{-- The accordion script is no longer needed since we are not displaying the lecture list inside the index page. --}}
{{-- The only thing left is the style which is already included in the push('styles') section. --}}
<script>
    // No JS needed for the new layout, as the "All Lectures" button is a direct link
    // and the "Payment" button is also a direct link/action.
</script>
@endpush