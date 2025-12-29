@extends('backend.admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="dashboard-view">

    <!-- Dashboard Cards -->
    <div class="grid-cards">
      <div class="card card-gradient-1">
        <div class="card-icon"><i class="fa fa-user-graduate"></i></div>
        <h3>Total Students</h3>
        <p class="stat" data-count="{{ $totalStudents ?? 0 }}">0</p>
      </div>

      <div class="card card-gradient-2">
        <div class="card-icon"><i class="fa fa-book-open"></i></div>
        <h3>Total Courses</h3>
        <p class="stat" data-count="{{ $totalCourses ?? 0 }}">0</p>
      </div>

      <div class="card card-gradient-3">
        <div class="card-icon"><i class="fa fa-money-bill"></i></div>
        <h3>Unpaid Students</h3>
        <p class="stat" data-count="{{ $totalUnpaidStudents ?? 0 }}">0</p>
      </div>

      <div class="card card-gradient-4">
        <div class="card-icon"><i class="fa fa-bell"></i></div>
        <h3>Total Notices</h3>
        <p class="stat" data-count="{{ $totalNotices ?? 0 }}">0</p>
      </div>
    </div>

    <!-- Recent Students Table -->
    <div class="modern-panel">
      <div class="panel-header">
        <h2>Recent Students</h2>
        <a href="{{ route('admin.students') }}" class="panel-btn">View All</a>
      </div>
      <div class="panel-body table-responsive">
        <table class="table modern-table" style="width: 100%; border-collapse: separate;">
          <thead>
            <tr>
              <th style="width: 3%; padding: 12px 8px;"></th>
              <th style="width: 5%; padding: 12px 8px;">ID</th>
              <th style="width: 8%; padding: 12px 8px;">Picture</th>
              <th style="width: 19%; padding: 12px 8px;">Name</th>
              <th style="width: 20%; padding: 12px 8px;">Email</th>
              <th style="width: 10%; padding: 12px 8px;">Class</th>
              <th style="width: 15%; padding: 12px 8px;">Phone</th>
              <th style="width: 20%; min-width: 140px; padding: 12px 8px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentStudents as $student)
              <tr data-student-id="{{ $student->id }}" class="student-row">
                <td class="text-center toggle-cell" data-id="{{ $student->id }}" style="vertical-align: middle;">
                  <button class="btn btn-sm btn-ghost toggle-details-btn" type="button">
                    <i class="fa fa-chevron-down toggle-icon" id="toggle-icon-{{ $student->id }}"></i>
                    <span class="sr-only">View Courses</span>
                  </button>
                </td>
                <td data-label="ID" style="vertical-align: middle;">{{ $student->id }}</td>
                <td data-label="Profile" style="vertical-align: middle;">
                  <img
                    src="{{ $student->profile_image ? asset('uploads/students/' . $student->profile_image) : asset('default-avatar.png') }}"
                    alt="{{ $student->name }}" class="profile-image-small"
                    onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}';">
                </td>
                <td data-label="Name" style="vertical-align: middle;">{{ $student->name }}</td>
                <td data-label="Email" style="vertical-align: middle;">{{ $student->email }}</td>
                <td data-label="Class" style="vertical-align: middle;">{{ $student->class ?? '-' }}</td>
                <td data-label="Phone" style="vertical-align: middle;">{{ $student->phone_number ?? '-' }}</td>
                <td data-label="Actions" style="white-space: nowrap; vertical-align: middle;">
                  <div class="action-buttons" style="display: inline-flex; gap: 5px;">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-info"
                      style="border-radius: 6px;">
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                      class="deleteForm inline-form" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit" style="border-radius: 6px;">
                        <i class="fa fa-trash"></i> Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              {{-- Nested Courses Row --}}
              <tr id="details-{{ $student->id }}" class="nested-details-row collapse-row" style="display: none;">
                <td colspan="8" class="details-cell">
                  <div class="nested-content">
                    @if($student->courses->isNotEmpty())
                      <h4 style="font-size: 1.1rem; font-weight: 600; color: #007bff; margin-bottom: 15px;">
                        <i class="fa fa-book-open"></i> Enrolled Courses ({{ $student->courses->count() }})
                      </h4>
                      <table class="inner-table" style="width: 100%;">
                        <thead>
                          <tr>
                            <th style="width: 45%;">Course Title</th>
                            <th style="width: 25%;">Enrollment Date</th>
                            <th style="width: 30%;">Payment Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($student->courses as $course)
                            @php
                              $pivot = $course->pivot;
                              $paymentStatus = strtolower($pivot->payment);
                              $courseRowId = $student->id . '-' . $course->id;
                            @endphp
                            <tr id="course-row-{{ $courseRowId }}">
                              <td>{{ $course->title ?? 'N/A' }}</td>
                              <td>{{ $pivot->created_at ? $pivot->created_at->format('M d, Y') : 'N/A' }}</td>
                              <td style="position: relative;">
                                <select class="payment-select form-control {{ $paymentStatus }}"
                                  data-student-id="{{ $student->id }}" data-course-id="{{ $course->id }}" style="width: 100%;">
                                  <option value="pending" {{ $paymentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                                  <option value="done" {{ $paymentStatus === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                                <span id="status-message-{{ $courseRowId }}" class="status-message"></span>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <p class="small text-right text-muted" style="margin-top: 15px; font-size: 0.85rem; color: #999;">*
                        Status updates are saved instantly upon selection.</p>
                    @else
                      <p class="muted text-center" style="padding: 15px; color: #777;">
                        <i class="fa fa-exclamation-circle"></i> This student is not currently enrolled in any courses.
                      </p>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="muted text-center" style="padding: 20px;">No recent students found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @push('scripts')
      <script>
        document.querySelectorAll('.toggle-details-btn').forEach(button => {
          button.addEventListener('click', function () {
            const studentId = this.closest('tr').dataset.studentId;
            const detailsRow = document.getElementById('details-' + studentId);
            const icon = document.getElementById('toggle-icon-' + studentId);

            if (detailsRow.style.display === 'none') {
              detailsRow.style.display = 'table-row';
              icon.classList.remove('fa-chevron-down');
              icon.classList.add('fa-chevron-up');
            } else {
              detailsRow.style.display = 'none';
              icon.classList.remove('fa-chevron-up');
              icon.classList.add('fa-chevron-down');
            }
          });
        });
      </script>
    @endpush

  </div>
@endsection

@push('styles')
  <style>
    /* Grid Cards */
    .grid-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 25px;
    }

    /* Card Styles */
    .card {
      border-radius: 12px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      color: #fff;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    }

    /* Card Gradient Backgrounds */
    .card-gradient-1 {
      background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    .card-gradient-2 {
      background: linear-gradient(135deg, #ff416c, #ff4b2b);
    }

    .card-gradient-3 {
      background: linear-gradient(135deg, #00c6ff, #0072ff);
    }

    .card-gradient-4 {
      background: linear-gradient(135deg, #f7971e, #ffd200);
    }

    /* Icon Animation */
    .card-icon {
      font-size: 2.2rem;
      margin-bottom: 12px;
      transition: transform 0.3s ease;
    }

    .card:hover .card-icon {
      transform: scale(1.3) rotate(-10deg);
    }

    /* Title & Stat */
    .card h3 {
      font-size: 1rem;
      margin-bottom: 6px;
    }

    .card .stat {
      font-size: 1.8rem;
      font-weight: 700;
    }

    /* Modern Panel/Table */
    .modern-panel {
      background: linear-gradient(145deg, #ffffff, #f1f6ff);
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin-top: 20px;
    }

    .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .panel-header h2 {
      font-size: 1.2rem;
      font-weight: 600;
      color: #2575fc;
      margin: 0;
    }

    .panel-btn {
      text-decoration: none;
      background: #2575fc;
      color: #fff;
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .panel-btn:hover {
      background: #1a4db7;
      transform: translateY(-2px);
    }

    /* Table Card Style */
    .modern-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 12px;
    }

    .modern-table th {
      text-align: left;
      padding: 12px 16px;
      font-weight: 600;
      color: #2575fc;
      background: transparent;
    }

    .modern-table td {
      padding: 12px 16px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
    }

    .modern-table tr:hover td {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .muted {
      color: #999;
      text-align: center;
    }

    .student-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #eee;
    }

    /* Responsive Table */
    @media(max-width:768px) {
      .modern-table thead {
        display: none;
      }

      .modern-table tr {
        display: block;
        margin-bottom: 16px;
      }

      .modern-table td {
        display: flex;
        justify-content: space-between;
        padding: 12px 16px;
      }

      .modern-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #666;
      }

      .text-center {
        text-align: right !important;
      }
    }
  </style>
@endpush

@push('scripts')
  <script>
    // Animated counting numbers
    document.querySelectorAll('.stat').forEach(el => {
      const count = parseInt(el.getAttribute('data-count'));
      let current = 0;
      const increment = Math.ceil(count / 100);
      const interval = setInterval(() => {
        current += increment;
        if (current >= count) { current = count; clearInterval(interval); }
        el.textContent = current;
      }, 15);
    });
  </script>
@endpush