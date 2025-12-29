@extends('backend.admin.layouts.app')

@section('title', 'Students')

@section('content')

<div class="students-dashboard">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('danger'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('danger') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-users"></i> Manage Students</h1>
            <p class="subtitle">View and manage all registered students</p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Add New Student
        </a>
    </div>

    {{-- Filter Section with Live Search --}}
    <div class="filter-card">
        <form id="filterForm" action="{{ route('admin.students') }}" method="GET">
            <div class="filter-grid-enhanced">
                {{-- Live Search Input --}}
                <div class="filter-group">
                    <label for="search">
                        <i class="fas fa-search"></i> Search Student
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           placeholder="Search by name or email..." 
                           value="{{ request('search') }}"
                           class="filter-input">
                    <small class="search-hint">
                        <i class="fas fa-info-circle"></i> Results update as you type
                    </small>
                </div>

                {{-- Class Filter --}}
                <div class="filter-group">
                    <label for="class">
                        <i class="fas fa-school"></i> Filter by Class
                    </label>
                    <select name="class" id="class" class="filter-select">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Status Filter --}}
                <div class="filter-group">
                    <label for="payment_status">
                        <i class="fas fa-money-bill-wave"></i> Payment Status
                    </label>
                    <select name="payment_status" id="payment_status" class="filter-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="done" {{ request('payment_status') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                {{-- Per Page Selection --}}
                <div class="filter-group">
                    <label for="per_page">
                        <i class="fas fa-list-ol"></i> Show Per Page
                    </label>
                    <select name="per_page" id="per_page" class="filter-select">
                        <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page', 5) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page', 5) == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page', 5) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 5) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>

                {{-- Hidden Sort Fields --}}
                <input type="hidden" name="sort_by" id="sort_by" value="{{ request('sort_by', 'id') }}">
                <input type="hidden" name="sort_order" id="sort_order" value="{{ request('sort_order', 'desc') }}">

                {{-- Filter Actions --}}
                <div class="filter-actions">
                    @if(request('search') || request('class') || request('payment_status'))
                        <a href="{{ route('admin.students') }}" class="btn-clear">
                            <i class="fas fa-times"></i> Clear All Filters
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Students Table --}}
    <div class="students-table-card">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Student List ({{ $students->total() }})</h3>
            <div class="sort-info">
                <i class="fas fa-sort"></i> 
                <span>Sorted by: <strong>{{ ucfirst(request('sort_by', 'id')) }}</strong> 
                ({{ request('sort_order', 'desc') == 'desc' ? 'Latest First' : 'Oldest First' }})</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="students-table">
                <thead>
                    <tr>
                        <th width="5%">
                            <a href="#" class="sort-link" data-sort="id">
                                ID 
                                <i class="fas fa-sort{{ request('sort_by') == 'id' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th width="10%">Profile</th>
                        <th width="20%">
                            <a href="#" class="sort-link" data-sort="name">
                                Name 
                                <i class="fas fa-sort{{ request('sort_by') == 'name' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th width="20%">
                            <a href="#" class="sort-link" data-sort="email">
                                Email 
                                <i class="fas fa-sort{{ request('sort_by') == 'email' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" class="sort-link" data-sort="class">
                                Class 
                                <i class="fas fa-sort{{ request('sort_by') == 'class' ? (request('sort_order') == 'asc' ? '-up' : '-down') : '' }}"></i>
                            </a>
                        </th>
                        <th width="15%">Phone</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    @forelse($students as $student)
                        <tr class="student-row">
                            <td data-label="ID">
                                <span class="student-id">#{{ $student->id }}</span>
                            </td>

                            <td data-label="Profile">
                                <div class="profile-cell">
                                    <img src="{{ $student->profile_image ? asset('storage/' . $student->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=667eea&color=fff' }}"
                                         alt="{{ $student->name }}" 
                                         class="profile-img"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=667eea&color=fff';">
                                </div>
                            </td>

                            <td data-label="Name">
                                <div class="name-cell">
                                    <span class="student-name">{{ $student->name }}</span>
                                </div>
                            </td>

                            <td data-label="Email">
                                <span class="student-email">{{ $student->email }}</span>
                            </td>

                            <td data-label="Class">
                                <span class="class-badge">{{ $student->class }}</span>
                            </td>

                            <td data-label="Phone">
                                <span class="phone-text">{{ $student->phone_number ?? 'N/A' }}</span>
                            </td>

                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <button class="btn-action btn-view" 
                                            onclick="openDetailsModal({{ $student->id }})"
                                            title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <button class="btn-action btn-courses" 
                                            onclick="openCoursesModal({{ $student->id }})"
                                            title="View Courses">
                                        <i class="fas fa-book"></i>
                                        <span class="course-count">{{ $student->courses->count() }}</span>
                                    </button>
                                    
                                    <a href="{{ route('admin.students.edit', $student) }}" 
                                       class="btn-action btn-edit"
                                       title="Edit Student">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.students.destroy', $student) }}" 
                                          method="POST" 
                                          class="delete-form"
                                          onsubmit="return confirm('Are you sure you want to delete {{ $student->name }}? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete Student">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-content">
                                    <i class="fas fa-users-slash"></i>
                                    <p>No students found</p>
                                    <small>Try adjusting your filters or add a new student</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $students->links('pagination::bootstrap-5') }}

        </div>
    </div>
</div>

{{-- Student Details Modal --}}
<div id="detailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-circle"></i> Student Details</h3>
            <button class="modal-close" onclick="closeDetailsModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="detailsModalBody">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>
</div>

{{-- Courses Modal --}}
<div id="coursesModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-book-reader"></i> Enrolled Courses</h3>
            <button class="modal-close" onclick="closeCoursesModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="coursesModalBody">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';
let searchTimeout = null;

// Live Search Functionality
document.getElementById('search').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500); // 500ms debounce
});

// Auto-submit on filter changes
document.getElementById('class').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.getElementById('payment_status').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.getElementById('per_page').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// Sorting functionality
document.querySelectorAll('.sort-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const sortBy = this.dataset.sort;
        const currentSortBy = document.getElementById('sort_by').value;
        const currentSortOrder = document.getElementById('sort_order').value;
        
        // Toggle sort order if clicking the same column
        if (currentSortBy === sortBy) {
            document.getElementById('sort_order').value = currentSortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            document.getElementById('sort_by').value = sortBy;
            document.getElementById('sort_order').value = 'desc';
        }
        
        document.getElementById('filterForm').submit();
    });
});

// Student Details Modal Functions
function openDetailsModal(studentId) {
    const modal = document.getElementById('detailsModal');
    const modalBody = document.getElementById('detailsModalBody');
    
    modal.classList.add('active');
    modalBody.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
    
    fetch(`/admin/students/${studentId}/details`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                modalBody.innerHTML = generateDetailsHTML(data.student);
            } else {
                modalBody.innerHTML = '<div class="error-message">Failed to load student details</div>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            modalBody.innerHTML = '<div class="error-message">An error occurred while loading details</div>';
        });
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.remove('active');
}

function generateDetailsHTML(student) {
    return `
        <div class="details-content">
            <div class="details-header">
                <img src="${student.profile_image}" 
                     alt="${student.name}" 
                     class="details-profile-img"
                     onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(student.name)}&background=667eea&color=fff';">
                <div class="details-header-info">
                    <h2>${student.name}</h2>
                    <p class="details-email"><i class="fas fa-envelope"></i> ${student.email}</p>
                    <span class="details-class-badge">${student.class}</span>
                </div>
            </div>

            <div class="details-section">
                <h4><i class="fas fa-id-card"></i> Personal Information</h4>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value">${student.phone_number || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date of Birth:</span>
                        <span class="detail-value">${student.dob || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Gender:</span>
                        <span class="detail-value">${student.gender ? student.gender.charAt(0).toUpperCase() + student.gender.slice(1) : 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Group:</span>
                        <span class="detail-value">${student.blood_group || 'N/A'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Religion:</span>
                        <span class="detail-value">${student.religion || 'N/A'}</span>
                    </div>
                </div>
            </div>

            <div class="details-section">
                <h4><i class="fas fa-user-friends"></i> Guardian Information</h4>
                
                <div class="guardian-box">
                    <h5><i class="fas fa-male"></i> Father's Details</h5>
                    <div class="details-grid-2">
                        <div class="detail-item">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">${student.father_name || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mobile:</span>
                            <span class="detail-value">${student.father_phone || 'N/A'}</span>
                        </div>
                    </div>
                </div>

                <div class="guardian-box">
                    <h5><i class="fas fa-female"></i> Mother's Details</h5>
                    <div class="details-grid-2">
                        <div class="detail-item">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">${student.mother_name || 'N/A'}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mobile:</span>
                            <span class="detail-value">${student.mother_phone || 'N/A'}</span>
                        </div>
                    </div>
                </div>

                ${student.alt_guardian_name ? `
                <div class="guardian-box">
                    <h5><i class="fas fa-user-shield"></i> Alternative Guardian</h5>
                    <div class="details-grid-2">
                        <div class="detail-item">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">${student.alt_guardian_name}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Mobile:</span>
                            <span class="detail-value">${student.alt_guardian_phone || 'N/A'}</span>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>

            <div class="details-section">
                <h4><i class="fas fa-map-marked-alt"></i> Address Information</h4>
                <div class="address-box">
                    <h5><i class="fas fa-home"></i> Present Address</h5>
                    <p>${student.present_address || 'N/A'}</p>
                </div>
                <div class="address-box">
                    <h5><i class="fas fa-map-marker-alt"></i> Permanent Address</h5>
                    <p>${student.permanent_address || 'N/A'}</p>
                </div>
            </div>
        </div>
    `;
}

// Courses Modal Functions
function openCoursesModal(studentId) {
    const modal = document.getElementById('coursesModal');
    const modalBody = document.getElementById('coursesModalBody');
    
    modal.classList.add('active');
    modalBody.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
    
    fetch(`/admin/students/${studentId}/courses`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                modalBody.innerHTML = generateCoursesHTML(data.student, data.courses);
            } else {
                modalBody.innerHTML = '<div class="error-message">Failed to load courses</div>';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            modalBody.innerHTML = '<div class="error-message">An error occurred while loading courses</div>';
        });
}

function closeCoursesModal() {
    document.getElementById('coursesModal').classList.remove('active');
}

function generateCoursesHTML(student, courses) {
    if (courses.length === 0) {
        return `
            <div class="empty-courses">
                <i class="fas fa-book-open"></i>
                <h3>${student.name}</h3>
                <p>This student is not enrolled in any courses yet.</p>
            </div>
        `;
    }

    let coursesHTML = `
        <div class="courses-header-info">
            <h3>${student.name}</h3>
            <p>Enrolled in ${courses.length} course(s)</p>
        </div>
        <div class="courses-list">
    `;

    courses.forEach(course => {
        const statusClass = course.payment.toLowerCase();
        coursesHTML += `
            <div class="course-item">
                <div class="course-info">
                    <h4><i class="fas fa-book-open"></i> ${course.title}</h4>
                    <p class="course-date">
                        <i class="fas fa-calendar"></i> Enrolled: ${new Date(course.enrollment_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}
                    </p>
                </div>
                <div class="course-payment">
                    <label>Payment Status:</label>
                    <select class="payment-select ${statusClass}" 
                            data-student-id="${student.id}"
                            data-course-id="${course.id}"
                            onchange="updatePaymentStatus(this)">
                        <option value="pending" ${course.payment === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="done" ${course.payment === 'done' ? 'selected' : ''}>Done</option>
                    </select>
                    <span class="status-feedback" id="status-${student.id}-${course.id}"></span>
                </div>
            </div>
        `;
    });

    coursesHTML += '</div>';
    return coursesHTML;
}

function updatePaymentStatus(selectElement) {
    const studentId = selectElement.dataset.studentId;
    const courseId = selectElement.dataset.courseId;
    const newStatus = selectElement.value;
    const feedback = document.getElementById(`status-${studentId}-${courseId}`);
    const oldClass = selectElement.className.match(/(pending|done)/)?.[0] || 'pending';
    
    selectElement.disabled = true;
    selectElement.classList.remove(oldClass);
    selectElement.classList.add(newStatus);
    feedback.textContent = 'Saving...';
    feedback.className = 'status-feedback saving';

    fetch(`/admin/students/${studentId}/courses/${courseId}/update-payment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ payment_status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            feedback.textContent = 'Saved!';
            feedback.className = 'status-feedback success';
        } else {
            throw new Error('Update failed');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        selectElement.value = oldClass;
        selectElement.classList.remove(newStatus);
        selectElement.classList.add(oldClass);
        feedback.textContent = 'Error!';
        feedback.className = 'status-feedback error';
    })
    .finally(() => {
        selectElement.disabled = false;
        setTimeout(() => {
            feedback.textContent = '';
            feedback.className = 'status-feedback';
        }, 3000);
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const detailsModal = document.getElementById('detailsModal');
    const coursesModal = document.getElementById('coursesModal');
    
    if (event.target === detailsModal) {
        closeDetailsModal();
    }
    if (event.target === coursesModal) {
        closeCoursesModal();
    }
}
</script>

<style>
:root {
    --primary: #667eea;
    --primary-dark: #5568d3;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #212529;
    --border: #dee2e6;
}

* { box-sizing: border-box; }

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.students-dashboard {
    padding: 30px 20px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Alerts */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
    animation: slideDown 0.3s ease;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid var(--success);
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid var(--danger);
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0 0 5px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.subtitle {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 1rem;
}

.btn-add {
    background: white;
    color: var(--primary);
    padding: 12px 24px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Enhanced Filter Card */
.filter-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.filter-grid-enhanced {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-input,
.filter-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.filter-input:focus,
.filter-select:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-hint {
    margin-top: 5px;
    color: #6c757d;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.filter-actions {
    display: flex;
    align-items: flex-end;
}

.btn-clear {
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    background: var(--danger);
    color: white;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-clear:hover {
    background: #c82333;
    transform: translateY(-1px);
}

/* Table Card */
.students-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.table-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-info {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.table-responsive {
    overflow-x: auto;
}

.students-table {
    width: 100%;
    border-collapse: collapse;
}

.students-table thead th {
    background: #f8f9fa;
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
    border-bottom: 2px solid var(--border);
}

.sort-link {
    color: var(--dark);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.sort-link:hover {
    color: var(--primary);
}

.sort-link i {
    font-size: 0.85rem;
    opacity: 0.5;
}

.sort-link:hover i {
    opacity: 1;
}

.students-table tbody tr {
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.students-table tbody tr:hover {
    background: #f8f9fa;
}

.students-table td {
    padding: 15px 12px;
    vertical-align: middle;
}

.student-id {
    font-weight: 600;
    color: var(--primary);
}

.profile-cell {
    display: flex;
    align-items: center;
}

.profile-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f0f0f0;
}

.student-name {
    font-weight: 600;
    color: var(--dark);
}

.student-email {
    color: #6c757d;
    font-size: 0.9rem;
}

.class-badge {
    background: linear-gradient(135deg, var(--primary), #764ba2);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.phone-text {
    color: var(--dark);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
    text-decoration: none;
}

.btn-view {
    background: #e3f2fd;
    color: #1976d2;
}

.btn-view:hover {
    background: #1976d2;
    color: white;
}

.btn-courses {
    background: #f3e5f5;
    color: #7b1fa2;
}

.btn-courses:hover {
    background: #7b1fa2;
    color: white;
}

.course-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--danger);
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-edit {
    background: #fff3cd;
    color: #856404;
}

.btn-edit:hover {
    background: #ffc107;
    color: white;
}

.btn-delete {
    background: #f8d7da;
    color: #721c24;
}

.btn-delete:hover {
    background: var(--danger);
    color: white;
}

.delete-form {
    display: inline;
}

/* Empty State */
.empty-state {
    padding: 60px 20px !important;
    text-align: center;
}

.empty-content i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 15px;
}

.empty-content p {
    font-size: 1.1rem;
    color: var(--dark);
    margin: 10px 0 5px 0;
}

.empty-content small {
    color: #6c757d;
}

/* Pagination */

/* Center the pagination container */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 25px 0;
}

/* Style the pagination itself */
.pagination {
    display: flex;
    gap: 6px;
    background: #fff;
    padding: 10px 15px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

/* Page links */
.pagination .page-link {
    border: 1px solid #ddd;
    color: #333;
    border-radius: 8px;
    padding: 8px 14px;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}

/* Hover and focus */
.pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    transform: translateY(-1px);
}

/* Active page */
.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0, 123, 255, 0.3);
}

/* Disabled (Prev/Next) */
.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa;
    color: #ccc;
    border-color: #eee;
    cursor: not-allowed;
}

/* Responsive behavior */
@media (max-width: 576px) {
    .pagination .page-link {
        padding: 6px 10px;
        font-size: 14px;
    }
}


/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    animation: fadeIn 0.3s ease;
}

.modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 700px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    animation: slideUp 0.3s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 25px 30px;
    background: linear-gradient(135deg, var(--primary), #764ba2);
    color: white;
    border-radius: 20px 20px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.modal-body {
    padding: 30px;
    overflow-y: auto;
    flex: 1;
}

.loading-spinner {
    text-align: center;
    padding: 40px;
    color: var(--primary);
    font-size: 1.2rem;
}

.loading-spinner i {
    font-size: 2rem;
    margin-bottom: 10px;
}

.error-message {
    text-align: center;
    padding: 40px;
    color: var(--danger);
    font-weight: 600;
}

/* Details Modal Content */
.details-content {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.details-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--border);
}

.details-profile-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary);
}

.details-header-info h2 {
    margin: 0 0 8px 0;
    font-size: 1.8rem;
    color: var(--dark);
}

.details-email {
    color: #6c757d;
    margin: 5px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.details-class-badge {
    background: linear-gradient(135deg, var(--primary), #764ba2);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-block;
    margin-top: 5px;
}

.details-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
}

.details-section h4 {
    margin: 0 0 20px 0;
    font-size: 1.2rem;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 10px;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.details-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.detail-item {
    background: white;
    padding: 12px 15px;
    border-radius: 8px;
    border-left: 3px solid var(--primary);
}

.detail-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.detail-value {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
}

.guardian-box {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 2px solid #e9ecef;
}

.guardian-box:last-child {
    margin-bottom: 0;
}

.guardian-box h5 {
    margin: 0 0 15px 0;
    font-size: 1rem;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.address-box {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    border-left: 4px solid var(--info);
}

.address-box:last-child {
    margin-bottom: 0;
}

.address-box h5 {
    margin: 0 0 10px 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.address-box p {
    margin: 0;
    color: #6c757d;
    line-height: 1.6;
}

/* Courses Modal Content */
.courses-header-info {
    text-align: center;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--border);
    margin-bottom: 20px;
}

.courses-header-info h3 {
    margin: 0 0 5px 0;
    font-size: 1.5rem;
    color: var(--dark);
}

.courses-header-info p {
    margin: 0;
    color: #6c757d;
}

.empty-courses {
    text-align: center;
    padding: 60px 20px;
}

.empty-courses i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 15px;
}

.empty-courses h3 {
    margin: 15px 0 10px 0;
    color: var(--dark);
}

.empty-courses p {
    color: #6c757d;
    margin: 0;
}

.courses-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.course-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.course-item:hover {
    border-color: var(--primary);
    background: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.course-info {
    flex: 1;
}

.course-info h4 {
    margin: 0 0 8px 0;
    font-size: 1.1rem;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.course-date {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.course-payment {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: flex-end;
}

.course-payment label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6c757d;
}

.payment-select {
    padding: 8px 12px;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px;
    text-align: center;
}

.payment-select.pending {
    background: #fff3cd;
    border-color: var(--warning);
    color: #856404;
}

.payment-select.done {
    background: #d4edda;
    border-color: var(--success);
    color: #155724;
}

.payment-select:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.status-feedback {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    min-height: 24px;
}

.status-feedback.saving {
    color: var(--info);
}

.status-feedback.success {
    background: var(--success);
    color: white;
}

.status-feedback.error {
    background: var(--danger);
    color: white;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .students-dashboard {
        padding: 15px 10px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-content h1 {
        font-size: 1.5rem;
    }

    .btn-add {
        width: 100%;
        justify-content: center;
    }

    .filter-grid-enhanced {
        grid-template-columns: 1fr;
    }

    .filter-actions {
        width: 100%;
    }

    .btn-clear {
        width: 100%;
        justify-content: center;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .sort-info {
        width: 100%;
        justify-content: center;
    }

    .students-table thead {
        display: none;
    }

    .students-table tbody tr {
        display: block;
        margin-bottom: 15px;
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 15px;
        background: white;
    }

    .students-table td {
        display: block;
        padding: 8px 0;
        border: none;
        text-align: left !important;
    }

    .students-table td:before {
        content: attr(data-label);
        font-weight: 700;
        color: var(--primary);
        display: block;
        margin-bottom: 5px;
        font-size: 0.85rem;
    }

    .students-table td:first-child:before {
        content: 'ID: ';
        display: inline;
    }

    .action-buttons {
        justify-content: flex-start;
        margin-top: 10px;
    }

    .modal-content {
        width: 95%;
        max-height: 95vh;
    }

    .modal-header {
        padding: 20px;
    }

    .modal-header h3 {
        font-size: 1.2rem;
    }

    .modal-body {
        padding: 20px;
    }

    .details-header {
        flex-direction: column;
        text-align: center;
    }

    .details-header-info h2 {
        font-size: 1.4rem;
    }

    .details-grid,
    .details-grid-2 {
        grid-template-columns: 1fr;
    }

    .course-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .course-payment {
        width: 100%;
        align-items: stretch;
    }

    .payment-select {
        width: 100%;
    }
}
</style>
@endpush