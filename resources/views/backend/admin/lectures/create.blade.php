@extends('backend.admin.layouts.app')

@section('title', 'Add New Lecture')

@section('content')
<div class="form-dashboard">
    <div class="panel modern-panel">
        <header class="panel-header">
            <h2>Add New Lecture 📝</h2>
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

            <form method="POST" action="{{ route('admin.lectures.store') }}">
                @csrf

                {{-- Course Dropdown --}}
                <div class="form-group">
                    <label for="course_id">Select Course <span class="required">*</span></label>
                    <select id="course_id" name="course_id" required class="@error('course_id') is-invalid @enderror">
                        <option value="">-- Choose Course --</option>
                        {{-- $courses should be passed as an array of ID => Title from the controller --}}
                        @foreach($courses as $id => $title)
                            <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>
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
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                {{-- Lecture Order --}}
                <div class="form-group">
                    <label for="order">Lecture No ( Serial Number )</label>
                    <input type="number" id="order" name="order" min="0" value="{{ old('order', 0) }}">
                </div>

                {{-- Lecture Type --}}
                <div class="form-group">
                    <label for="type">Lecture Type <span class="required">*</span></label>
                    <select id="type" name="type" required>
                        <option value="pre_recorded" {{ old('type') == 'pre_recorded' ? 'selected' : '' }}>Pre-recorded</option>
                        <option value="live" {{ old('type') == 'live' ? 'selected' : '' }}>Live</option>
                    </select>
                </div>

                {{-- YouTube Link --}}
                <div class="form-group">
                    <label for="youtube_link">Video Link (YouTube / Other)</label>
                    <input type="url" id="youtube_link" name="youtube_link" placeholder="https://youtube.com/..." value="{{ old('youtube_link') }}">
                </div>

                {{-- Live Scheduled Time (Conditional) --}}
                <div class="form-group" id="live_scheduled_at_group" style="display:none;">
                    <label for="live_scheduled_at">Live Scheduled At</label>
                    <input type="datetime-local" id="live_scheduled_at" name="live_scheduled_at" value="{{ old('live_scheduled_at') }}">
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Lecture</button>
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
            // Set live_scheduled_at as required when type is live
            document.getElementById('live_scheduled_at').setAttribute('required', 'required');
        } else {
            liveGroup.style.display = 'none';
            document.getElementById('live_scheduled_at').removeAttribute('required');
        }
    }

    typeSelect.addEventListener('change', toggleLiveField);
    // Initialize the state based on the current value (e.g., if old('type') was 'live')
    toggleLiveField();
});
</script>
@endpush