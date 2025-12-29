@extends('backend.student.layouts.app')
@section('title','Student Dashboard')

@section('content')
<div class="dashboard-view fade-in">

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card purple">
            <i class="fa fa-book-open"></i>
            <div>
                <h3>{{ $paidCourses->count() }}</h3>
                <p>My Courses</p>
            </div>
        </div>
        <div class="stat-card blue">
            <i class="fa fa-bullhorn"></i>
            <div>
                <h3>{{ $notices->count() }}</h3>
                <p>Notices</p>
            </div>
        </div>
        <div class="stat-card green">
            <i class="fa fa-video"></i>
            <div>
                <h3>{{ $liveLectures->count() }}</h3>
                <p>Live Classes</p>
            </div>
        </div>
    </div>

    <!-- My Courses -->
    <div class="modern-panel">
        <div class="panel-header">
            <h2><i class="fa fa-graduation-cap me-2 text-primary"></i> My Paid Courses</h2>
        </div>
        <div class="course-grid">
            @forelse($paidCourses as $course)
                <a href="{{ route('student.courses.show', $course->id) }}" class="course-card">
                    <div class="course-icon"><i class="fa fa-book"></i></div>
                    <h4>{{ $course->title }}</h4>
                    <p>{{ Str::limit($course->description, 60) }}</p>
                </a>
            @empty
                <p class="text-muted p-3">You haven’t enrolled in any paid courses yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Notices (Show only 2 latest) -->
    <div class="modern-panel">
        <div class="panel-header">
            <h2><i class="fa fa-bullhorn me-2 text-warning"></i> Recent Notices</h2>
            <a href="{{ route('student.notices') }}" class="panel-btn">View All</a>
        </div>
           <div class="notice-feed">
        @forelse($notices->take(2) as $notice)
            <div class="notice-card">
                <div class="notice-header">
                    <h5 class="notice-title">{{ $notice->title }}</h5>
                    <span class="notice-time">
                        <i class="fa fa-clock me-1"></i> 
                        {{ $notice->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="notice-body">
                    {!! Str::limit(strip_tags($notice->content), 200) !!}
                </div>
            </div>
        @empty
            <p class="text-muted p-3">No notices available.</p>
        @endforelse
    </div>
</div>

    <!-- Live Classes -->
    <div class="modern-panel">
        <div class="panel-header">
            <h2><i class="fa fa-video me-2 text-success"></i> Live Classes</h2>
            <a href="{{ route('student.courses') }}" class="panel-btn">View All</a>
        </div>
        <div class="live-class-list">
            @forelse($liveLectures as $lecture)
                <div class="live-item">
                    <div>
                        <h5>{{ $lecture->title }}</h5>
                        <p>Course: {{ $lecture->course->title }}</p>
                    </div>
                    <span class="status-badge pulse">Live</span>
                </div>
            @empty
                <p class="text-muted p-3">No live classes currently available.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* General */
.fade-in { animation: fadeIn 0.6s ease-in; }
@keyframes fadeIn { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }

.dashboard-view {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
}

/* === Stats Section === */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform .3s ease;
}
.stat-card:hover { transform: translateY(-5px); }
.stat-card i { font-size: 2rem; margin-right: 15px; }
.stat-card h3 { margin: 0; font-size: 1.6rem; font-weight: 700; }
.stat-card p { margin: 0; opacity: 0.9; font-size: 0.9rem; }
.purple { background: linear-gradient(135deg, #6a11cb, #2575fc); }
.blue   { background: linear-gradient(135deg, #36D1DC, #5B86E5); }
.green  { background: linear-gradient(135deg, #00b09b, #96c93d); }

/* === Courses === */
.course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
    padding: 20px;
}
.course-card {
    background: linear-gradient(135deg, #ff9966, #ff5e62);
    color: #fff;
    padding: 20px;
    border-radius: 14px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}
.course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
.course-icon { font-size: 1.8rem; margin-bottom: 10px; }

/* === Notice Feed === */
.notice-feed {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.notice-card {
    background: #f9f9ff;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 15px 18px;
    transition: box-shadow .3s ease, transform .2s;
}
.notice-card:hover {
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    transform: translateY(-3px);
}
.notice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 8px;
}
.notice-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}
.notice-time {
    font-size: 0.85rem;
    color: #888;
}
.notice-body {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.5;
}

/* === Live Classes === */
.live-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}
.status-badge {
    background: #28a745;
    color: #fff;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}
.pulse {
    animation: pulse 1.5s infinite;
}
@keyframes pulse {
    0% {box-shadow: 0 0 0 0 rgba(40,167,69,0.5);}
    70% {box-shadow: 0 0 0 10px rgba(40,167,69,0);}
    100% {box-shadow: 0 0 0 0 rgba(40,167,69,0);}
}

/* === Panels === */
.modern-panel {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}
.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    flex-wrap: wrap;
}
.panel-header h2 {
    font-size: 1.2rem;
    margin: 0;
    font-weight: 700;
}
.panel-btn {
    background: #2575fc;
    color: #fff;
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 0.9rem;
}
.panel-btn:hover { background: #1a5edb; }

/* === Responsive === */
@media (max-width: 768px) {
    .panel-header { flex-direction: column; align-items: flex-start; }
    .panel-btn { margin-top: 10px; }
    .notice-header { flex-direction: column; align-items: flex-start; gap: 5px; }
    .stats-grid { grid-template-columns: 1fr; }
    .course-grid { grid-template-columns: 1fr; }
    .notice-body { font-size: 0.9rem; }
}
</style>
@endpush
