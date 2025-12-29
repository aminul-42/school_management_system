@extends('backend.admin.layouts.app')

@section('title', 'All Lectures')

@section('content')

@if (session('success'))
    <div class="alert success">{{ session('success') }}</div>
@endif

@if (session('danger'))
    <div class="alert danger">{{ session('danger') }}</div>
@endif

<div class="panel modern-panel">
    <header class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Course Lectures Management 📚</h2>
        <a href="{{ route('admin.lectures.create') }}" class="btn">
            <i class="fa fa-plus"></i> Add New Lecture
        </a>
    </header>

    <div class="panel-body">

        {{-- Course Selection Dropdown --}}
        <div class="form-group" style="max-width: 450px; margin-bottom: 25px;">
            <label for="course_selector" style="font-weight: 600; margin-bottom: 8px; display: block; color: var(--text-color);">Select a Course to View Lectures:</label>
            <select id="course_selector" class="form-control" style="padding: 10px; border-radius: 6px; border: 1px solid var(--border-color); width: 100%; appearance: menulist-button;">
                <option value="">-- Choose a Course --</option>
                {{-- $courses should be passed from the controller --}}
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 30px 0;">

        {{-- Placeholder for Lectures Table (Loaded via AJAX) --}}
        <div id="lectures-table-container">
            <p class="muted" style="text-align: center; padding: 50px; font-size: 1.1rem; color: #6c757d;">
                <i class="fa fa-hand-point-up"></i> Please select a course from the dropdown above to view its lectures.
            </p>
        </div>

        {{-- Loading Indicator --}}
        <div id="loading-spinner" style="text-align: center; padding: 20px; display: none;">
            <i class="fa fa-spinner fa-spin fa-2x" style="color: var(--primary);"></i> Loading lectures...
        </div>

    </div>
</div>

{{-- ------------------------------------------------------------------- --}}
{{-- ⚠️ CSS for Delete Confirmation Modal (Placed in the main file) ⚠️ --}}
{{-- ------------------------------------------------------------------- --}}
<style>
    .confirm-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex; justify-content: center; align-items: center;
        z-index: 9999; /* Higher z-index for visibility */
    }
    .confirm-box {
        background: #fff; padding: 30px; border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        max-width: 400px; width: 90%; text-align: center;
    }
    .confirm-box h3 {
        margin-top: 0; color: var(--danger, #F44336); font-size: 1.5rem;
    }
    .confirm-box p {
        margin-bottom: 25px; color: #555;
    }
    .confirm-actions {
        display: flex; justify-content: space-around; gap: 10px;
    }
    .confirm-actions .btn-confirm {
        background: var(--danger, #F44336); color: white; border: none;
        padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600;
    }
    .confirm-actions .btn-cancel {
        background: #ccc; color: #333; border: none;
        padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600;
    }
</style>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelector = document.getElementById('course_selector');
    const tableContainer = document.getElementById('lectures-table-container');
    const loadingSpinner = document.getElementById('loading-spinner');

    function loadLectures(courseId) {
        tableContainer.innerHTML = '';
        loadingSpinner.style.display = 'block';

        // Use the route helper for reliability
        const url = '{{ url('admin/lectures/by-course') }}/' + courseId; 

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server returned ' + response.status + ' error.');
            }
            return response.text();
        })
        .then(html => {
            tableContainer.innerHTML = html;
            loadingSpinner.style.display = 'none';
        })
        .catch(error => {
            console.error('Fetch error:', error);
            loadingSpinner.style.display = 'none';
            tableContainer.innerHTML = '<p class="alert danger" style="text-align: center;">' +
                                       '<i class="fa fa-exclamation-triangle"></i> Error loading lectures. Please check the route and controller.' +
                                       '</p>';
        });
    }

    // Listener for Course Selector
    courseSelector.addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            loadLectures(courseId);
        } else {
            tableContainer.innerHTML = '<p class="muted" style="text-align: center; padding: 50px; font-size: 1.1rem; color: #6c757d;">' +
                                       '<i class="fa fa-hand-point-up"></i> Please select a course from the dropdown above to view its lectures.' +
                                       '</p>';
        }
    });

    // ------------------------------------------------------------------
    // Global Delete Confirmation Listener (using Event Delegation)
    // ------------------------------------------------------------------
    document.addEventListener('submit', function (e) {
        // Check if the submitted element is a form with the class 'deleteForm'
        if (e.target.matches('.deleteForm')) {
            e.preventDefault(); // Stop default submit

            const form = e.target;
            
            // Remove existing modal
            const existingModal = document.querySelector('.confirm-overlay');
            if (existingModal) existingModal.remove();

            // Create and append modal HTML
            const modal = document.createElement('div');
            modal.classList.add('confirm-overlay');
            modal.innerHTML = `
            <div class="confirm-box">
                <h3>Confirm Deletion</h3>
                <p>Are you sure you want to permanently delete this lecture?</p>
                <div class="confirm-actions">
                    <button type="button" class="btn-confirm">Yes, Delete</button>
                    <button type="button" class="btn-cancel">Cancel</button>
                </div>
            </div>
            `;
            document.body.appendChild(modal);

            // Attach event handlers to the new buttons
            modal.querySelector('.btn-cancel').addEventListener('click', () => modal.remove());
            modal.querySelector('.btn-confirm').addEventListener('click', () => {
                modal.remove();
                // Optional: Show loading spinner before submitting
                // loadingSpinner.style.display = 'block'; 
                form.submit(); // Submit the original form after confirmation
            });
        }
    });

    // Load lectures if a course was already selected (e.g., after validation error)
    if (courseSelector.value) {
        loadLectures(courseSelector.value);
    }
});
</script>
@endpush