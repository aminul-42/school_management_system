@extends('backend.admin.layouts.app')
@section('title', 'Edit Notice')

@section('content')
<div class="container">
    <div class="modern-panel">
        <div class="panel-header">
            <h2>Edit Notice</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.notices.update', $notice->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $notice->title) }}">
                    @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" rows="4">{{ old('content', $notice->content) }}</textarea>
                    @error('content')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="target_type">Target Type</label>
                    <select name="target_type" id="target_type" required>
                        <option value="all" {{ old('target_type', $notice->target_type) == 'all' ? 'selected' : '' }}>All Students</option>
                        <option value="course" {{ old('target_type', $notice->target_type) == 'course' ? 'selected' : '' }}>Specific Course</option>
                        <option value="student" {{ old('target_type', $notice->target_type) == 'student' ? 'selected' : '' }}>Specific Student</option>
                    </select>
                </div>

                {{-- Course --}}
                <div class="form-group {{ old('target_type', $notice->target_type) == 'course' ? '' : 'd-none' }}" id="target_course">
                    <label for="target_course_id">Select Course</label>
                    <select name="target_course_id" id="target_course_id" {{ old('target_type', $notice->target_type) == 'course' ? 'required' : '' }}>
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('target_course_id', $notice->target_type == 'course' ? $notice->target_id : '') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Student --}}
                <div class="form-group {{ old('target_type', $notice->target_type) == 'student' ? '' : 'd-none' }}" id="target_student">
                    <label for="target_student_id">Select Student</label>
                    <select name="target_student_id" id="target_student_id" {{ old('target_type', $notice->target_type) == 'student' ? 'required' : '' }}>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" 
                                {{ old('target_student_id', $notice->target_type == 'student' ? $notice->target_id : '') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check" style="margin-bottom: 20px;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input"
                        {{ old('is_active', $notice->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>

                <button type="submit" class="btn">Update Notice</button>
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
