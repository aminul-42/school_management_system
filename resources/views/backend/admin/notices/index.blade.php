@extends('backend.admin.layouts.app')
@section('title', 'Manage Notices')

@section('content')
<div class="notices-dashboard">
    
    <!-- Alerts: ENSURING SUCCESS AND DANGER MESSAGES DISPLAY CORRECTLY -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('danger'))
        <div class="alert alert-danger">{{ session('danger') }}</div>
    @endif

    <!-- Top Actions (Matching Courses Structure) -->
    <div class="top-actions" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Manage Notices</h2>
        <a href="{{ route('admin.notices.create') }}" class="btn btn-primary-icon"><i class="fa fa-plus"></i> Add Notice</a>
    </div>

    <!-- Notices Table -->
    <div class="panel modern-panel">
        <header class="panel-header">
            <h2>Notices List</h2>
        </header>

        <div class="panel-body table-responsive">

            {{-- Notices Table --}}
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices as $notice)
                        <tr>
                            {{-- Serial Number: Simple count now that pagination is removed --}}
                            <td data-label="#">
                                {{ $loop->iteration }}
                            </td>

                            <td data-label="Title">{{ $notice->title }}</td>
                            <td data-label="Target">
                                @if($notice->target_type === 'all')
                                    All Students
                                @elseif($notice->target_type === 'course')
                                    Course: {{ $notice->course->title ?? 'N/A' }}
                                @else
                                    Student: {{ $notice->student->name ?? 'N/A' }}
                                @endif
                            </td>

                            <td data-label="Status">
                                {{-- Status Pill with Custom Design --}}
                                <span class="status-toggle-pill 
                                    @if($notice->is_active) active @else inactive @endif" 
                                    data-id="{{ $notice->id }}"
                                    data-status="{{ $notice->is_active ? 'active' : 'inactive' }}">
                                    @if($notice->is_active)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </span>
                            </td>

                            <td data-label="Created At">{{ $notice->created_at->format('d M Y') }}</td>

                            <td data-label="Actions" class="action-buttons">
                                {{-- Changed to ghost style with icon --}}
                                <a href="{{ route('admin.notices.edit', $notice->id) }}"
                                   class="btn btn-ghost"><i class="fa fa-edit"></i> Edit</a>
                                   
                                {{-- Changed to full danger button with icon --}}
                                <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST"
                                    class="d-inline deleteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center muted">No notices yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

{{-- Custom Styles for Alerts, Status Pill, and Button Design --}}
@push('styles')
<style>
/* 1. ALERT STYLING (Ensure visibility and contrast) */
.alert {
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid transparent;
    border-radius: 0.5rem;
    font-weight: 500;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.alert-success {
    color: #155724; /* Dark green text */
    background-color: #d4edda; /* Light green background */
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24; /* Dark red text */
    background-color: #f8d7da; /* Light red background */
    border-color: #f5c6cb;
}

/* 2. STATUS PILL DESIGN */
.status-toggle-pill {
    display: inline-block;
    padding: 0.3rem 0.75rem;
    border-radius: 9999px; /* Pill shape */
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    min-width: 80px;
    user-select: none;
}

.status-toggle-pill.active {
    background-color: #10b981; /* Tailwind green-500 */
    color: white;
    border: 1px solid #059669;
}

.status-toggle-pill.inactive {
    background-color: #f3f4f6; /* Tailwind gray-100 */
    color: #4b5563; /* Tailwind gray-600 */
    border: 1px solid #d1d5db;
}

.status-toggle-pill:hover {
    opacity: 0.9;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* 3. BUTTON STYLING (Matching Courses Index) */
.btn {
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.875rem;
}

.btn-primary-icon { /* Used for the main "Add Notice" button */
    background-color: #3b82f6; /* Blue */
    color: white;
}
.btn-primary-icon:hover {
    background-color: #2563eb;
}

.btn-ghost { /* Used for the Edit button */
    background: transparent;
    color: #4b5563; /* Gray text */
    border-color: transparent;
}
.btn-ghost:hover {
    background-color: #f3f4f6; /* Light gray background on hover */
    color: #1f2937;
}

.btn-danger {
    background-color: #ef4444; /* Red */
    color: white;
}
.btn-danger:hover {
    background-color: #dc2626;
}

/* 4. Layout and Responsive Adjustments */
.notices-dashboard {
    padding: 20px;
}

.modern-panel {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    background-color: white;
}

.panel-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.table.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.table.modern-table thead th {
    background-color: #f9fafb;
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 700;
    color: #374151;
}

.table.modern-table tbody td {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    vertical-align: middle;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-start;
    align-items: center;
}
/* Responsive Adjustment */
@media (max-width: 768px) {
    .modern-table thead {
        display: none;
    }
    .modern-table tbody td {
        display: block;
        text-align: right;
        padding-left: 30%;
        position: relative;
    }
    .modern-table tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 40%;
        padding-right: 10px;
        white-space: nowrap;
        text-align: left;
        font-weight: 600;
        color: #4b5563;
    }
    .action-buttons {
        justify-content: flex-end;
    }
}
</style>
@endpush

{{-- Custom Script for form handling and status logic simulation --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle DELETE form submission confirmation
        const deleteForms = document.querySelectorAll('.deleteForm');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // IMPORTANT: Replace this with a custom UI modal, as window.confirm() is forbidden.
                console.warn('ACTION REQUIRED: Delete confirmation dialog is simulated via console. In a real app, use a custom modal here.');
                // e.preventDefault(); // Uncomment this line if you implement a custom modal and need to wait for user confirmation
            });
        });

        // Optional: Simulate Status Toggle Clicks for enhanced UI experience
        const statusPills = document.querySelectorAll('.status-toggle-pill');
        statusPills.forEach(pill => {
            pill.addEventListener('click', function() {
                const noticeId = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                
                // In a real Laravel application, you would make an AJAX call here:
                // axios.post(`/admin/notices/${noticeId}/toggle-status`).then(response => { ... });
                
                console.log(`Simulating status toggle for Notice ID: ${noticeId}. New status should be: ${currentStatus === 'active' ? 'inactive' : 'active'}`);
                
                // For demonstration, visually toggle the state
                if (currentStatus === 'active') {
                    this.classList.remove('active');
                    this.classList.add('inactive');
                    this.textContent = 'Inactive';
                    this.setAttribute('data-status', 'inactive');
                } else {
                    this.classList.remove('inactive');
                    this.classList.add('active');
                    this.textContent = 'Active';
                    this.setAttribute('data-status', 'active');
                }
            });
        });
    });
</script>
@endpush
