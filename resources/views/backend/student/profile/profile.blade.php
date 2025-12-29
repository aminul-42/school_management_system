@extends('backend.student.layouts.app')

@section('title','Student Profile')

@section('content')
<div class="container profile-page-container">
    
    <div class="profile-card">
        
        {{-- Profile Header with Avatar --}}
        <div class="profile-header">
            <div class="profile-image-container">
                <img src="{{ $student->profile_image ? asset('storage/' . $student->profile_image) : 'https://placehold.co/120x120/007bff/ffffff?text=AVATAR' }}"
                     alt="{{ $student->name }}'s Profile Picture" 
                     class="profile-picture"
                     onerror="this.onerror=null; this.src='https://placehold.co/120x120/ced4da/6c757d?text=ERROR';"
                >
            </div>
            <div class="main-info">
                <h1 class="student-name-main">{{ $student->name }}</h1>
                <p class="student-class-main"><i class="fas fa-graduation-cap"></i> Class: {{ $student->class }}</p>
                <p class="student-email"><i class="fas fa-envelope"></i> {{ $student->email }}</p>
            </div>
        </div>

        {{-- Personal Information Cards --}}
        <div class="info-section">
            <h3 class="section-title"><i class="fas fa-user-circle"></i> Personal Information</h3>
            <div class="info-cards">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-content">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value">{{ $student->phone_number ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="info-content">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $student->dob ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                    <div class="info-content">
                        <span class="info-label">Gender</span>
                        <span class="info-value">{{ ucfirst($student->gender) ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-tint"></i></div>
                    <div class="info-content">
                        <span class="info-label">Blood Group</span>
                        <span class="info-value">{{ $student->blood_group ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-praying-hands"></i></div>
                    <div class="info-content">
                        <span class="info-label">Religion</span>
                        <span class="info-value">{{ $student->religion ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Guardian Information --}}
        <div class="info-section">
            <h3 class="section-title"><i class="fas fa-user-friends"></i> Guardian Information</h3>
            
            {{-- Father's Information --}}
            <div class="guardian-group">
                <div class="guardian-header">
                    <i class="fas fa-male"></i>
                    <span>Father's Details</span>
                </div>
                <div class="guardian-details">
                    <div class="guardian-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <span class="g-label">Name</span>
                            <span class="g-value">{{ $student->father_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="guardian-item">
                        <i class="fas fa-mobile-alt"></i>
                        <div>
                            <span class="g-label">Mobile</span>
                            <span class="g-value">{{ $student->father_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mother's Information --}}
            <div class="guardian-group">
                <div class="guardian-header">
                    <i class="fas fa-female"></i>
                    <span>Mother's Details</span>
                </div>
                <div class="guardian-details">
                    <div class="guardian-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <span class="g-label">Name</span>
                            <span class="g-value">{{ $student->mother_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="guardian-item">
                        <i class="fas fa-mobile-alt"></i>
                        <div>
                            <span class="g-label">Mobile</span>
                            <span class="g-value">{{ $student->mother_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alternative Guardian --}}
            @if($student->alt_guardian_name)
            <div class="guardian-group">
                <div class="guardian-header">
                    <i class="fas fa-user-shield"></i>
                    <span>Alternative Guardian</span>
                </div>
                <div class="guardian-details">
                    <div class="guardian-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <span class="g-label">Name</span>
                            <span class="g-value">{{ $student->alt_guardian_name }}</span>
                        </div>
                    </div>
                    <div class="guardian-item">
                        <i class="fas fa-mobile-alt"></i>
                        <div>
                            <span class="g-label">Mobile</span>
                            <span class="g-value">{{ $student->alt_guardian_phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Address Information --}}
        <div class="info-section">
            <h3 class="section-title"><i class="fas fa-map-marked-alt"></i> Address Information</h3>
            <div class="address-cards">
                <div class="address-card">
                    <div class="address-icon present"><i class="fas fa-home"></i></div>
                    <div class="address-content">
                        <span class="address-label">Present Address</span>
                        <span class="address-value">{{ $student->present_address ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="address-card">
                    <div class="address-icon permanent"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="address-content">
                        <span class="address-label">Permanent Address</span>
                        <span class="address-value">{{ $student->permanent_address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Course Enrollments --}}
        <div class="info-section">
            <h3 class="section-title"><i class="fas fa-book-reader"></i> Course Enrollments</h3>
            
            @if($student->courses->isEmpty())
                <div class="alert-box">
                    <i class="fas fa-info-circle"></i>
                    <span>You are not currently enrolled in any courses.</span>
                </div>
            @else
                <div class="courses-grid">
                    @foreach ($student->courses as $course)
                        <div class="course-card">
                            <div class="course-header">
                                <div class="course-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="course-title">{{ $course->title }}</div>
                            </div>
                            <div class="course-info">
                                <div class="course-meta">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $course->pivot->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="course-payment">
                                    <span class="payment-badge {{ $course->pivot->payment }}">
                                        <i class="fas fa-{{ $course->pivot->payment === 'done' ? 'check-circle' : 'exclamation-circle' }}"></i>
                                        {{ ucfirst($course->pivot->payment) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Action Button --}}
        <div class="profile-actions">
            <a href="{{ route('student.profile.edit', $student) }}" class="btn-edit-profile">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        </div>
        
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #007bff;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
        --bg-light: #f8f9fa;
        --bg-white: #ffffff;
        --text-dark: #212529;
        --text-muted: #6c757d;
        --border: #dee2e6;
        --shadow: rgba(0, 0, 0, 0.08);
        --shadow-lg: rgba(0, 0, 0, 0.15);
    }

    * { box-sizing: border-box; }
    
    body { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    .profile-page-container { 
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .profile-card { 
        background: var(--bg-white);
        border-radius: 20px;
        box-shadow: 0 20px 60px var(--shadow-lg);
        padding: 0;
        overflow: hidden;
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, #0056b3 100%);
        color: white;
        padding: 40px 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
    }

    .profile-image-container {
        position: relative;
    }

    .profile-picture {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .main-info {
        width: 100%;
    }

    .student-name-main {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .student-class-main,
    .student-email {
        font-size: 1rem;
        margin: 5px 0;
        opacity: 0.95;
    }

    .student-class-main i,
    .student-email i {
        margin-right: 8px;
        opacity: 0.8;
    }

    /* Section Styling */
    .info-section {
        padding: 35px 30px;
        border-bottom: 1px solid var(--border);
    }

    .info-section:last-of-type {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 25px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.3rem;
    }

    /* Info Cards Grid */
    .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .info-card {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow);
        border-color: var(--primary);
    }

    .info-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--primary), #0056b3);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .info-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        word-wrap: break-word;
    }

    /* Guardian Groups */
    .guardian-group {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 4px solid var(--primary);
    }

    .guardian-group:last-child {
        margin-bottom: 0;
    }

    .guardian-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--border);
    }

    .guardian-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .guardian-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: white;
        padding: 15px;
        border-radius: 8px;
    }

    .guardian-item > i {
        color: var(--primary);
        font-size: 1.1rem;
        margin-top: 2px;
    }

    .guardian-item > div {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .g-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .g-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-dark);
        word-wrap: break-word;
    }

    /* Address Cards */
    .address-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .address-card {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 15px;
        border-left: 4px solid var(--info);
    }

    .address-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
    }

    .address-icon.present {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .address-icon.permanent {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .address-content {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .address-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .address-value {
        font-size: 0.95rem;
        color: var(--text-dark);
        line-height: 1.5;
        word-wrap: break-word;
    }

    /* Course Cards */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .course-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 20px;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px var(--shadow);
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px var(--shadow-lg);
    }

    .course-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .course-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .course-title {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.3;
    }

    .course-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .course-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        opacity: 0.95;
    }

    .payment-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .payment-badge.done {
        background: var(--success);
        color: white;
    }

    .payment-badge.pending {
        background: var(--warning);
        color: var(--text-dark);
    }

    /* Alert Box */
    .alert-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        color: #856404;
    }

    .alert-box i {
        font-size: 1.5rem;
    }

    /* Action Button */
    .profile-actions {
        padding: 30px;
        text-align: center;
        background: var(--bg-light);
    }

    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--primary), #0056b3);
        color: white;
        padding: 14px 32px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        color: white;
    }

    /* Responsive Design */
    @media (min-width: 768px) {
        .profile-header {
            flex-direction: row;
            text-align: left;
            justify-content: flex-start;
        }

        .main-info {
            width: auto;
        }

        .profile-picture {
            width: 140px;
            height: 140px;
        }

        .student-name-main {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 767px) {
        .profile-card {
            border-radius: 15px;
        }

        .profile-header {
            padding: 30px 20px;
        }

        .info-section {
            padding: 25px 20px;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .info-cards {
            grid-template-columns: 1fr;
        }

        .guardian-details {
            grid-template-columns: 1fr;
        }

        .address-cards {
            grid-template-columns: 1fr;
        }

        .courses-grid {
            grid-template-columns: 1fr;
        }

        .profile-actions {
            padding: 20px;
        }

        .btn-edit-profile {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        body {
            padding: 10px 0;
        }

        .profile-header {
            padding: 25px 15px;
        }

        .student-name-main {
            font-size: 1.75rem;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
        }

        .info-section {
            padding: 20px 15px;
        }
    }
</style>
@endpush