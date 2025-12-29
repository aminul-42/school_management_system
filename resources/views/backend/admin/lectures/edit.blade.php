@extends('backend.admin.layouts.app')

@section('title', 'Edit Lecture: ' . $lecture->title)

@section('content')
<div class="form-dashboard">
    <div class="panel modern-panel">
        <header class="panel-header">
            <h2>Edit Lecture: {{ $lecture->title }} ✏️</h2>
            <a href="{{ route('admin.lectures.index') }}" class="btn btn-ghost">
                <i class="fa fa-list"></i> View All Lectures
            </a>
        </header>

        <div class="panel-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert danger">
                    <p><strong>Please fix the following errors:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.lectures.update', $lecture) }}">
                @csrf
                {{-- Use the @method('PUT') directive for updating resources in Laravel --}}
                @method('PUT')

                {{-- Course Dropdown --}}
                <div class="form-group">
                    <label for="course_id">Select Course <span class="required">*</span></label>
                    <select id="course_id" name="course_id" required class="@error('course_id') is-invalid @enderror">
                        <option value="">-- Choose Course --</option>
                        @foreach($courses as $id => $title)
                            {{-- Check if old input or current lecture data matches the course ID --}}
                            <option value="{{ $id }}" {{ (old('course_id', $lecture->course_id) == $id) ? 'selected' : '' }}>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Lecture Title --}}
                <div class="form-group">
                    <label for="title">Lecture Title <span class="required">*</span></label>
                    {{-- Use old('title', $lecture->title) to persist input on error --}}
                    <input type="text" id="title" name="title" value="{{ old('title', $lecture->title) }}" required>
                </div>

                {{-- Lecture Order --}}
                <div class="form-group">
                    <label for="order">Lecture No ( Serial Number )</label>
                    <input type="number" id="order" name="order" min="0" value="{{ old('order', $lecture->order) }}">
                </div>

                {{-- Lecture Type --}}
                <div class="form-group">
                    <label for="type">Lecture Type <span class="required">*</span></label>
                    <select id="type" name="type" required>
                        <option value="pre_recorded" {{ old('type', $lecture->type) == 'pre_recorded' ? 'selected' : '' }}>Pre-recorded</option>
                        <option value="live" {{ old('type', $lecture->type) == 'live' ? 'selected' : '' }}>Live</option>
                    </select>
                </div>

                {{-- YouTube Link --}}
                <div class="form-group">
                    <label for="youtube_link">Video Link (YouTube / Other)</label>
                    <input type="url" id="youtube_link" name="youtube_link" placeholder="https://youtube.com/..." value="{{ old('youtube_link', $lecture->youtube_link) }}">
                </div>

                {{-- Live Scheduled Time --}}
                <div class="form-group" id="live_scheduled_at_group" style="display:none;">
                    <label for="live_scheduled_at">Live Scheduled At</label>
                    @php
                        // Format the date for the datetime-local input, handling nulls
                        $scheduledTime = $lecture->live_scheduled_at ? \Carbon\Carbon::parse($lecture->live_scheduled_at)->format('Y-m-d\TH:i') : null;
                    @endphp
                    <input type="datetime-local" id="live_scheduled_at" name="live_scheduled_at" value="{{ old('live_scheduled_at', $scheduledTime) }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Lecture</button>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const liveGroup = document.getElementById('live_scheduled_at_group');

    function toggleLiveField() {
        if (typeSelect.value === 'live') {
            liveGroup.style.display = 'block';
            // Require field when type is live
            document.getElementById('live_scheduled_at').setAttribute('required', 'required');
        } else {
            liveGroup.style.display = 'none';
            document.getElementById('live_scheduled_at').removeAttribute('required');
        }
    }

    typeSelect.addEventListener('change', toggleLiveField);
    // Initialize the state based on the lecture's current type
    toggleLiveField();
});
</script>
@endpush