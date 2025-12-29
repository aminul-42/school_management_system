@extends('backend.student.layouts.app') 

@section('title', 'Important Notices')

@section('content')

<div class="card">
    <h2 class="card-title">📢 Important Notices</h2>

    {{-- Eager load relationships in controller to prevent N+1 issues (e.g., Notices::with('course')->get()) --}}
    
    @forelse($notices as $notice)
        {{-- Use an inner card structure for each notice item --}}
        <div class="card mb-4" style="padding: 15px; border-left: 5px solid {{ $notice->target_type == 'all' ? 'var(--primary-blue)' : ($notice->target_type == 'course' ? 'var(--accent-yellow)' : 'var(--success)') }};">
            <h5 style="color: var(--primary-dark); font-weight: 700; margin-bottom: 5px;">
                {{ $notice->title }}
            </h5>
            
            <p style="font-size: 0.95rem; color: #555; margin-bottom: 10px;">
                {!! nl2br(e($notice->content)) !!}
            </p>

            <footer style="font-size: 0.8rem; color: var(--muted); border-top: 1px dashed #eee; padding-top: 8px; display: flex; justify-content: space-between;">
                <span>
                  Notice Published At: {{ $notice->created_at->format('M d, Y') }} ({{ $notice->created_at->diffForHumans() }})
                </span>
                
                {{-- Targeting Label --}}
                <span class="badge" style="
                    background: {{ $notice->target_type == 'all' ? 'var(--success)' : ($notice->target_type == 'course' ? 'var(--primary-blue)' : 'var(--danger)') }}; 
                    color: var(--white); 
                    padding: 4px 8px; 
                    border-radius: 6px; 
                    font-weight: 600;
                ">
                    @if($notice->target_type == 'all')
                        <i class="fa fa-users"></i> General Notice For All Students
                    @elseif($notice->target_type == 'course' && $notice->course)
                        <i class="fa fa-graduation-cap"></i> Notice For Course : {{ $notice->course->title }}
                    @elseif($notice->target_type == 'student')
                        <i class="fa fa-user-check"></i> Personal Notice
                    @endif
                </span>
            </footer>
        </div>
    @empty
        <div class="alert" style="padding: 20px; background: var(--background); border: 2px solid #ddd; border-radius: 10px; text-align: center;">
            <i class="fa fa-inbox fa-2x" style="color: var(--primary-blue); margin-bottom: 10px;"></i>
            <p style="font-weight: 600; color: #555;">No active notices found for you right now. Keep up the great work! ✨</p>
        </div>
    @endforelse

    {{-- Pagination Links --}}
    @if ($notices->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notices->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <style>
        /* Optional: Add a custom style for the pagination links if they don't look right */
        .pagination .page-item.active .page-link {
            background-color: var(--accent-yellow) !important;
            border-color: var(--accent-yellow) !important;
            color: var(--primary-dark) !important;
        }
    </style>
@endpush