@extends('backend.admin.layouts.app')

@section('title', 'Add New Student')

@section('content')

<div class="form-container">
    <div class="form-card">
        {{-- Header --}}
        <div class="form-header">
            <div class="header-left">
                <h1><i class="fas fa-user-plus"></i> Add New Student</h1>
                <p>Fill in the details to register a new student</p>
            </div>
            <a href="{{ route('admin.students') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Information --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="Enter student's full name">
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required placeholder="student@email.com">
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Leave blank to use email as password">
                        <small class="help-text">Min 8 characters. If blank, email will be used as default password</small>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="class">Class / Batch <span class="required">*</span></label>
                        <select name="class" id="class" class="form-control @error('class') is-invalid @enderror" required>
                            <option value="">Select Class</option>
                            @foreach (['06', '07', '08', '09', '10', '11', '12', 'Admission', 'Special'] as $classOption)
                                <option value="{{ $classOption }}" {{ old('class') == $classOption ? 'selected' : '' }}>
                                    Class {{ $classOption }}
                                </option>
                            @endforeach
                        </select>
                        @error('class')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                               value="{{ old('phone_number') }}" placeholder="+880 1234567890">
                        @error('phone_number')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" 
                               value="{{ old('dob') }}">
                        @error('dob')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="blood_group">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="form-control @error('blood_group') is-invalid @enderror">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodGroup)
                                <option value="{{ $bloodGroup }}" {{ old('blood_group') == $bloodGroup ? 'selected' : '' }}>
                                    {{ $bloodGroup }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_group')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="text" name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror" 
                               value="{{ old('religion') }}" placeholder="e.g., Islam, Christianity">
                        @error('religion')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Guardian Information --}}
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-user-friends"></i> Guardian Information</h3>
                
                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-male"></i> Father's Details</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="father_name">Father's Name</label>
                            <input type="text" name="father_name" id="father_name" class="form-control @error('father_name') is-invalid @enderror" 
                                   value="{{ old('father_name') }}" placeholder="Enter father's name">
                            @error('father_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="father_phone">Father's Mobile</label>
                            <input type="text" name="father_phone" id="father_phone" class="form-control @error('father_phone') is-invalid @enderror" 
                                   value="{{ old('father_phone') }}" placeholder="+880 1234567890">
                            @error('father_phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-female"></i> Mother's Details</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="mother_name">Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" class="form-control @error('mother_name') is-invalid @enderror" 
                                   value="{{ old('mother_name') }}" placeholder="Enter mother's name">
                            @error('mother_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mother_phone">Mother's Mobile</label>
                            <input type="text" name="mother_phone" id="mother_phone" class="form-control @error('mother_phone') is-invalid @enderror" 
                                   value="{{ old('mother_phone') }}" placeholder="+880 1234567890">
                            @error('mother_phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="guardian-subsection">
                    <h4 class="subsection-title"><i class="fas fa-user-shield"></i> Alternative Guardian</h4>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="alt_guardian_name">Guardian Name</label>
                            <input type="text" name="alt_guardian_name" id="alt_guardian_name" class="form-control @error('alt_guardian_name') is-invalid @enderror" 
                                   value="{{ old('alt_guardian_name') }}" placeholder="Optional">
                            @error('alt_guardian_name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alt_guardian_phone">Guardian Mobile</label>
                            <input type="text" name="alt_guardian_phone" id="alt_guardian_phone" class="form-control @error('alt_guardian_phone') is-invalid @enderror" 
                                   value="{{ old('alt_guardian_phone') }}" placeholder="Optional">
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
                        <label for="present_address">Present Address</label>
                        <textarea name="present_address" id="present_address" rows="3" class="form-control @error('present_address') is-invalid @enderror" 
                                  placeholder="Enter current address">{{ old('present_address') }}</textarea>
                        @error('present_address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="permanent_address">Permanent Address</label>
                        <textarea name="permanent_address" id="permanent_address" rows="3" class="form-control @error('permanent_address') is-invalid @enderror" 
                                  placeholder="Enter permanent address">{{ old('permanent_address') }}</textarea>
                        @error('permanent_address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.students') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Student
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
:root {
    --primary: #667eea;
    --primary-dark: #5568d3;
    --success: #28a745;
    --danger: #dc3545;
    --light: #f8f9fa;
    --dark: #212529;
    --border: #dee2e6;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.form-container {
    padding: 30px 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
    color: white;
    padding: 35px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-left h1 {
    margin: 0 0 8px 0;
    font-size: 2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-left p {
    margin: 0;
    opacity: 0.95;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
}

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
    color: var(--dark);
    margin: 0 0 25px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--primary);
}

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

.guardian-subsection {
    background: var(--light);
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

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.required {
    color: var(--danger);
}

.form-control {
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
    color: #6c757d;
}

.error-text {
    display: block;
    margin-top: 6px;
    font-size: 0.85rem;
    color: var(--danger);
    font-weight: 600;
}

.form-actions {
    padding: 30px;
    background: var(--light);
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.btn-submit,
.btn-cancel {
    padding: 14px 32px;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-submit {
    background: linear-gradient(135deg, var(--primary), #764ba2);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    background: white;
    color: var(--dark);
    border: 2px solid var(--border);
}

.btn-cancel:hover {
    background: #f8f9fa;
}

@media (max-width: 768px) {
    .form-container {
        padding: 15px 10px;
    }

    .form-card {
        border-radius: 15px;
    }

    .form-header {
        padding: 25px 20px;
        flex-direction: column;
        align-items: flex-start;
    }

    .header-left h1 {
        font-size: 1.6rem;
    }

    .btn-back {
        width: 100%;
        justify-content: center;
    }

    .form-section {
        padding: 25px 20px;
    }

    .section-title {
        font-size: 1.2rem;
    }

    .form-grid,
    .form-grid-2 {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
        padding: 20px;
    }

    .btn-submit,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }

    .guardian-subsection {
        padding: 15px;
    }
}
</style>
@endpush