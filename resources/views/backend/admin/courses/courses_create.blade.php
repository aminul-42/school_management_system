@extends('backend.admin.layouts.app')

@section('title', 'Add Course')

@section('content')
  <div class="form-dashboard">

    <div class="panel modern-panel">
      <header class="panel-header">
        <h2>Add Course</h2>
      </header>
      <div class="panel-body">

        {{-- Show Validation Errors --}}
        @if ($errors->any())
          <div class="alert danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
          </div>

          <div class="form-group">
            <label>Image (max: 2MB)</label>
            <input type="file" name="image" accept="image/*">
          </div>

          <div class="form-group">
            <label>Instructor</label>
            <input type="text" name="instructor" value="{{ old('instructor') }}">
          </div>

          <div class="form-group">
            <label>Rating</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating') }}">
          </div>

          <div class="form-group">
            <label>Reviews</label>
            <input type="number" min="0" name="reviews" value="{{ old('reviews') }}">
          </div>

          <div class="form-group">
            <label>Lectures</label>
            <input type="number" min="0" name="lectures_count" value="{{ old('lectures_count') }}">
          </div>

          <div class="form-group">
            <label>Duration</label>
            <input type="text" name="duration" placeholder="e.g. 10h 30m" value="{{ old('duration') }}">
          </div>

          <div class="form-group">
            <label>Skill Level</label>
            <input type="text" name="skill_level" placeholder="Beginner / Advanced" value="{{ old('skill_level') }}">
          </div>

          <div class="form-group">
            <label>Language</label>
            <input type="text" name="language" placeholder="e.g. English" value="{{ old('language') }}">
          </div>

          <div class="form-group">
            <label>Fee ($)</label>
            <input type="number" name="fee" min="0" step="0.01" required value="{{ old('fee') }}">
          </div>

          <div class="form-group">
            <label>Offer Price ($)</label>
            <input type="number" name="offer_price" min="0" step="0.01" value="{{ old('offer_price') }}">
          </div>

          <div class="form-group">
            <label>Offer Expires At</label>
            <input type="datetime-local" name="offer_expires_at" value="{{ old('offer_expires_at') }}">
          </div>

          <button type="submit" class="btn">Save</button>
        </form>

      </div>
    </div>

  </div>
@endsection

@push('styles')
  <style>
    .form-dashboard { max-width: 480px; margin: auto; padding: 20px 0; }
    .panel-body .form-group { margin-bottom: 15px; display: flex; flex-direction: column; }
    .panel-body .form-group label { margin-bottom: 6px; font-weight: 500; }
    .panel-body .form-group input,
    .panel-body .form-group textarea,
    .panel-body .form-group select { padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 0.95rem; width: 100%; }
    .alert.danger { background: #ffe6e6; color: #a94442; padding: 10px; border-radius: 6px; margin-bottom: 15px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; font-size: 0.9rem; font-weight: 500; border-radius: 8px; border: 1px solid transparent; background: var(--blue); color: #fff; transition: all 0.3s ease; }
    .btn:hover { background: var(--blue-dark); transform: translateY(-2px); }
    @media(max-width:768px) { .form-dashboard { padding: 0 16px; } }
  </style>
@endpush
