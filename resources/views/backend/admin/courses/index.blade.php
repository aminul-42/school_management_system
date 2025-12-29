@extends('backend.admin.layouts.app')

@section('title', 'Courses')

@section('content')
  <div class="courses-dashboard">

    <!-- Alerts -->
    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif
    @if(session('danger'))
      <div class="alert danger">{{ session('danger') }}</div>
    @endif

    <!-- Top Actions -->
    <div class="top-actions" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <h2>Manage Courses</h2>
      <a href="{{ route('admin.courses.create') }}" class="btn"><i class="fa fa-plus"></i> Add Course</a>
    </div>

    <!-- Courses Table -->
    <div class="panel modern-panel">
      <header class="panel-header">
        <h2>Courses List</h2>
      </header>

      <div class="panel-body table-responsive">
        <table class="table modern-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Instructor</th>
              <th>Fee</th>
              <th>Offer Price</th>
              <th>Offer Expires</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($courses as $course)
              <tr>
                <td data-label="#">{{ $course->id }}</td>
                <td data-label="Title">{{ $course->title }}</td>
                <td data-label="Instructor">{{ $course->instructor ?? '-' }}</td>
                <td data-label="Fee">${{ $course->fee }}</td>
                <td data-label="Offer Price">
                  @if($course->offer_price)
                    ${{ $course->offer_price }}
                  @else
                    <span class="muted">N/A</span>
                  @endif
                </td>
                <td data-label="Offer Expires">
                  @if($course->offer_expires_at)
                    {{ \Carbon\Carbon::parse($course->offer_expires_at)->format('d M, Y') }}
                  @else
                    <span class="muted">N/A</span>
                  @endif
                </td>
                <td data-label="Actions" style="display:flex; gap:5px;">
                  <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-ghost"><i class="fa fa-edit"></i>
                    Edit</a>
                  <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="muted text-center">No courses found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top:15px;">
          {{ $courses->links() }}
        </div>
      </div>
    </div>

  </div>
@endsection



