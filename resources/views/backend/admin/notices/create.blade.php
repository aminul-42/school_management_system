@extends('backend.admin.layouts.app')
@section('title', 'Add Notice')

@section('content')
<div class="container">
    <div class="modern-panel">
        <div class="panel-header">
            <h2>Add New Notice</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.notices.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}">
                    @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" rows="4">{{ old('content') }}</textarea>
                    @error('content')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="target_type">Target Type</label>
                    <select name="target_type" id="target_type" required>
                        <option value="all" {{ old('target_type', 'all') == 'all' ? 'selected' : '' }}>All Students</option>
                        <option value="course" {{ old('target_type') == 'course' ? 'selected' : '' }}>Specific Course</option>
                        <option value="student" {{ old('target_type') == 'student' ? 'selected' : '' }}>Specific Student</option>
                    </select>
                </div>

                {{-- Course --}}
                <div class="form-group {{ old('target_type') == 'course' ? '' : 'd-none' }}" id="target_course">
                    <label for="target_course_id">Select Course <span class="text-danger">*</span></label>
                    <select name="target_course_id" id="target_course_id" {{ old('target_type') == 'course' ? 'required' : '' }}>
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('target_course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('target_course_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Student --}}
                <div class="form-group {{ old('target_type') == 'student' ? '' : 'd-none' }}" id="target_student">
                    <label for="target_student_id">Select Student <span class="text-danger">*</span></label>
                    <select name="target_student_id" id="target_student_id" {{ old('target_type') == 'student' ? 'required' : '' }}>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('target_student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('target_student_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-check" style="margin-bottom: 20px;">
                    <input type="hidden" name="is_active" value="0"> 
                    <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input"
                        {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>

                <button type="submit" class="btn">Save Notice</button>
                <a href="{{ route('admin.notices.index') }}" class="btn btn-ghost">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetTypeSelect = document.getElementById('target_type');
    const targetCourseDiv = document.getElementById('target_course');
    const targetStudentDiv = document.getElementById('target_student');
    const targetCourseSelect = document.getElementById('target_course_id');
    const targetStudentSelect = document.getElementById('target_student_id');

    function toggleTargetFields() {
        const selected = targetTypeSelect.value;

        // Hide all
        targetCourseDiv.classList.add('d-none');
        targetStudentDiv.classList.add('d-none');
        targetCourseSelect.removeAttribute('required');
        targetStudentSelect.removeAttribute('required');

        if (selected === 'course') {
            targetCourseDiv.classList.remove('d-none');
            targetCourseSelect.setAttribute('required', 'required');
        } else if (selected === 'student') {
            targetStudentDiv.classList.remove('d-none');
            targetStudentSelect.setAttribute('required', 'required');
        }
    }

    targetTypeSelect.addEventListener('change', toggleTargetFields);
    toggleTargetFields();
});
</script>
@endpush
@endsection
