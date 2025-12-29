@extends('backend.admin.layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="form-dashboard">

  <div class="panel modern-panel">
    <header class="panel-header">
      <h2>Edit Course</h2>
    </header>
    <div class="panel-body">
      @if ($errors->any())
        <div class="alert danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" value="{{ old('title', $course->title) }}" required>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" rows="3">{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="form-group">
          <label>Image</label>
          @if($course->image)
            <div><img src="{{ asset('storage/' . $course->image) }}" width="120" class="mb-2"></div>
          @endif
          <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group">
          <label>Instructor</label>
          <input type="text" name="instructor" value="{{ old('instructor', $course->instructor) }}">
        </div>

        <div class="form-group">
          <label>Rating</label>
          <input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', $course->rating) }}">
        </div>

        <div class="form-group">
          <label>Reviews</label>
          <input type="number" min="0" name="reviews" value="{{ old('reviews', $course->reviews) }}">
        </div>

        <div class="form-group">
          <label>Lectures</label>
          <input type="number" min="0" name="lectures_count" value="{{ old('lectures_count', $course->lectures_count) }}">
        </div>

        <div class="form-group">
          <label>Duration</label>
          <input type="text" name="duration" value="{{ old('duration', $course->duration) }}">
        </div>

        <div class="form-group">
          <label>Skill Level</label>
          <input type="text" name="skill_level" value="{{ old('skill_level', $course->skill_level) }}">
        </div>

        <div class="form-group">
          <label>Language</label>
          <input type="text" name="language" value="{{ old('language', $course->language) }}">
        </div>

        <div class="form-group">
          <label>Fee ($)</label>
          <input type="number" name="fee" min="0" step="0.01" value="{{ old('fee', $course->fee) }}" required>
        </div>

        <div class="form-group">
          <label>Offer Price ($)</label>
          <input type="number" name="offer_price" min="0" step="0.01"
                 value="{{ old('offer_price', $course->offer_price) }}">
        </div>

        <div class="form-group">
          <label>Offer Expires At</label>
          <input type="datetime-local" name="offer_expires_at"
                 value="{{ old('offer_expires_at', $course->offer_expires_at ? \Carbon\Carbon::parse($course->offer_expires_at)->format('Y-m-d\TH:i') : '') }}">
        </div>

        <button type="submit" class="btn">Update</button>
      </form>

    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
.form-dashboard {
  max-width: 500px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: 500;
}

.form-group input,
.form-group textarea {
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 0.95rem;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--blue);
}

.btn {
  width: 100%;
  justify-content: center;
}

@media(max-width:600px) {
  .form-dashboard {
    padding: 10px;
  }
}
</style>
@endpush
