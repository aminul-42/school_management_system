@extends('backend.student.layouts.app')

@section('title','Edit Student Profile')

@section('content')
<div class="container edit-profile-container">
    <div class="profile-card">
        
        {{-- Header --}}
        <div class="form-header">
            <div class="header-content">
                <h1 class="form-title"><i class="fas fa-user-edit"></i> Edit Profile</h1>
                <p class="form-subtitle">Update your personal information and settings</p>
            </div>
        </div>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert-box error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Please correct the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('student.profile.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Picture Section --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-camera"></i> Profile Picture</h3>
                <div class="profile-picture-section">
                    <div class="current-picture">
                        <img src="{{ $student->profile_image ? asset('storage/' . $student->profile_image) : 'https://placehold.co/120x120/007bff/ffffff?text=AVATAR' }}"
                             alt="Current Profile Picture" 
                             id="preview-image"
                             class="preview-img">
                    </div>
                    <div class="upload-controls">
                        <label for="profile_image" class="file-label">
                            <i class="fas fa-upload"></i> Choose New Picture
                        </label>
                        <input type="file" name="profile_image" id="profile_image" 
                               class="file-input @error('profile_image') is-invalid @enderror" 
                               accept="image/*">
                        <small class="help-text">Maximum file size: 2MB. Formats: JPG, PNG, GIF</small>
                        @error('profile_image')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Basic Information --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address <span class="required">*</span></label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="class"><i class="fas fa-graduation-cap"></i> Class <span class="required">*</span></label>
                        <select name="class" id="class" 
                                class="form-control @error('class') is-invalid @enderror" required>
                            <option value="">Select Class</option>
                            @foreach (['06', '07', '08', '09', '10', '11', '12', 'Admission', 'Special'] as $classOption)
                                <option value="{{ $classOption }}" 
                                        {{ old('class', $student->class) == $classOption ? 'selected' : '' }}>
                                    Class {{ $classOption }}
                                </option>
                            @endforeach
                        </select>
                        @error('class')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" 
                               class="form-control @error('phone_number') is-invalid @enderror" 
                               value="{{ old('phone_number', $student->phone_number) }}"
                               placeholder="Optional">
                        @error('phone_number')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dob"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                        <input type="date" name="dob" id="dob" 
                               class="form-control @error('dob') is-invalid @enderror" 
                               value="{{ old('dob', $student->dob) }}">
                        @error('dob')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="blood_group"><i class="fas fa-tint"></i> Blood Group</label>
                        <select name="blood_group" id="blood_group" class="form-control @error('blood_group') is-invalid @enderror">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodGroup)
                                <option value="{{ $bloodGroup }}" {{ old('blood_group', $student->blood_group) == $bloodGroup ? 'selected' : '' }}>
                                    {{ $bloodGroup }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_group')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="religion"><i class="fas fa-praying-hands"></i> Religion</label>
                        <input type="text" name="religion" id="religion" 
                               class="form-control @error('religion') is-invalid @enderror" 
                               value="{{ old('religion', $student->religion) }}">
                        @error('religion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Guardian Information --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-user-friends"></i> Guardian Information</h3>
                
                {{-- Father's Information --}}
                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-male"></i> Father's Details</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="father_name"><i class="fas fa-user"></i> Father's Name</label>
                            <input type="text" name="father_name" id="father_name" 
                                   class="form-control @error('father_name') is-invalid @enderror" 
                                   value="{{ old('father_name', $student->father_name) }}">
                            @error('father_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="father_phone"><i class="fas fa-mobile-alt"></i> Father's Mobile</label>
                            <input type="text" name="father_phone" id="father_phone" 
                                   class="form-control @error('father_phone') is-invalid @enderror" 
                                   value="{{ old('father_phone', $student->father_phone) }}">
                            @error('father_phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Mother's Information --}}
                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-female"></i> Mother's Details</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="mother_name"><i class="fas fa-user"></i> Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" 
                                   class="form-control @error('mother_name') is-invalid @enderror" 
                                   value="{{ old('mother_name', $student->mother_name) }}">
                            @error('mother_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mother_phone"><i class="fas fa-mobile-alt"></i> Mother's Mobile</label>
                            <input type="text" name="mother_phone" id="mother_phone" 
                                   class="form-control @error('mother_phone') is-invalid @enderror" 
                                   value="{{ old('mother_phone', $student->mother_phone) }}">
                            @error('mother_phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Alternative Guardian --}}
                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-user-shield"></i> Alternative Guardian</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="alt_guardian_name"><i class="fas fa-user"></i> Guardian Name</label>
                            <input type="text" name="alt_guardian_name" id="alt_guardian_name" 
                                   class="form-control @error('alt_guardian_name') is-invalid @enderror" 
                                   value="{{ old('alt_guardian_name', $student->alt_guardian_name) }}">
                            @error('alt_guardian_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alt_guardian_phone"><i class="fas fa-mobile-alt"></i> Guardian Mobile</label>
                            <input type="text" name="alt_guardian_phone" id="alt_guardian_phone" 
                                   class="form-control @error('alt_guardian_phone') is-invalid @enderror" 
                                   value="{{ old('alt_guardian_phone', $student->alt_guardian_phone) }}">
                            @error('alt_guardian_phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-map-marked-alt"></i> Address Information</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="present_address"><i class="fas fa-home"></i> Present Address</label>
                        <textarea name="present_address" id="present_address" rows="3"
                                  class="form-control @error('present_address') is-invalid @enderror">{{ old('present_address', $student->present_address) }}</textarea>
                        @error('present_address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="permanent_address"><i class="fas fa-map-marker-alt"></i> Permanent Address</label>
                        <textarea name="permanent_address" id="permanent_address" rows="3"
                                  class="form-control @error('permanent_address') is-invalid @enderror">{{ old('permanent_address', $student->permanent_address) }}</textarea>
                        @error('permanent_address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Security Settings --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-lock"></i> Security Settings</h3>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="password"><i class="fas fa-key"></i> New Password</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Leave blank to keep current password">
                        <small class="help-text">Minimum 8 characters required</small>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-key"></i> Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" 
                               placeholder="Re-enter new password">
                    </div>
                </div>
            </div>

            {{-- Course Selection --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-book-reader"></i> Course Enrollments</h3>
                <div class="course-selection @error('course_ids') is-invalid-border @enderror">
                    @foreach ($allCourses as $course)
                        <label class="course-checkbox">
                            <input type="checkbox" 
                                   name="course_ids[]" 
                                   value="{{ $course->id }}"
                                   {{ in_array($course->id, old('course_ids', $enrolledCourseIds)) ? 'checked' : '' }}>
                            <span class="checkbox-custom"></span>
                            <span class="course-name">{{ $course->title }}</span>
                        </label>
                    @endforeach
                </div>
                @error('course_ids')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="form-actions">
                <a href="{{ route('student.profile') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
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

    .edit-profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .profile-card {
        background: var(--bg-white);
        border-radius: 20px;
        box-shadow: 0 20px 60px var(--shadow-lg);
        overflow: hidden;
    }

    /* Header */
    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, #0056b3 100%);
        color: white;
        padding: 40px 30px;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-subtitle {
        margin: 0;
        opacity: 0.95;
        font-size: 1rem;
    }

    /* Alert Box */
    .alert-box {
        padding: 20px;
        margin: 20px 30px;
        border-radius: 12px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }

    .alert-box.error {
        background: #f8d7da;
        border: 2px solid var(--danger);
        color: #721c24;
    }

    .alert-box i {
        font-size: 1.5rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert-box ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    /* Form Sections */
    .form-section {
        padding: 35px 30px;
        border-bottom: 1px solid var(--border);
    }

    .form-section:last-of-type {
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

    /* Profile Picture Section */
    .profile-picture-section {
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .current-picture {
        flex-shrink: 0;
    }

    .preview-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--bg-light);
        box-shadow: 0 4px 15px var(--shadow);
    }

    .upload-controls {
        flex: 1;
        min-width: 250px;
    }

    .file-label {
        display: inline-block;
        padding: 12px 24px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }

    .file-label:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow);
    }

    .file-input {
        display: none;
    }

    /* Form Grids */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    /* Guardian Subsections */
    .guardian-subsection {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid var(--primary);
    }

    .guardian-subsection:last-child {
        margin-bottom: 0;
    }

    .subsection-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Groups */
    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .form-group label i {
        color: var(--primary);
        font-size: 0.9rem;
    }

    .required {
        color: var(--danger);
        font-weight: 700;
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--bg-white);
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .help-text {
        display: block;
        margin-top: 6px;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .error-text {
        display: block;
        margin-top: 6px;
        font-size: 0.85rem;
        color: var(--danger);
        font-weight: 600;
    }

    /* Course Selection */
    .course-selection {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 12px;
        max-height: 350px;
        overflow-y: auto;
        padding: 20px;
        background: var(--bg-light);
        border-radius: 12px;
        border: 2px solid var(--border);
    }

    .course-selection.is-invalid-border {
        border-color: var(--danger);
    }

    .course-checkbox {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .course-checkbox:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px var(--shadow);
    }

    .course-checkbox input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkbox-custom {
        width: 22px;
        height: 22px;
        border: 2px solid var(--border);
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .course-checkbox input[type="checkbox"]:checked ~ .checkbox-custom {
        background: var(--primary);
        border-color: var(--primary);
    }

    .course-checkbox input[type="checkbox"]:checked ~ .checkbox-custom::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: white;
        font-size: 0.75rem;
    }

    .course-name {
        font-weight: 500;
        color: var(--text-dark);
    }

    /* Action Buttons */
    .form-actions {
        padding: 30px;
        background: var(--bg-light);
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-primary,
    .btn-secondary {
        padding: 14px 32px;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), #0056b3);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    }

    .btn-secondary {
        background: white;
        color: var(--text-dark);
        border: 2px solid var(--border);
    }

    .btn-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-muted);
    }

    /* Image Preview Script */
    #profile_image + .file-label {
        display: inline-block;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-header {
            padding: 30px 20px;
        }

        .form-title {
            font-size: 1.6rem;
        }

        .form-section {
            padding: 25px 20px;
        }

        .profile-picture-section {
            flex-direction: column;
            text-align: center;
        }

        .upload-controls {
            width: 100%;
        }

        .file-label {
            width: 100%;
            text-align: center;
        }

        .form-grid,
        .form-grid-2 {
            grid-template-columns: 1fr;
        }

        .course-selection {
            grid-template-columns: 1fr;
            max-height: 300px;
        }

        .form-actions {
            flex-direction: column-reverse;
            padding: 20px;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .guardian-subsection {
            padding: 15px;
        }

        .alert-box {
            margin: 20px;
        }
    }

    @media (max-width: 480px) {
        body {
            padding: 10px 0;
        }

        .profile-card {
            border-radius: 15px;
        }

        .form-header {
            padding: 25px 15px;
        }

        .form-title {
            font-size: 1.4rem;
        }

        .form-section {
            padding: 20px 15px;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .preview-img {
            width: 100px;
            height: 100px;
        }

        .course-selection {
            padding: 15px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Image Preview Functionality
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-image').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush