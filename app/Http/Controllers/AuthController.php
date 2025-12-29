<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // --- Show login form ---
    public function showLoginForm()
    {
        return view('auth.login');
    }



    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];
        $debug = '';

        // ------------------------
        // 1️⃣ Admin login
        // ------------------------
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        // ------------------------
        // 2️⃣ Student login
        // ------------------------
        $student = Student::where('email', $email)->first();

        if ($student) {
            // Check password
            if (Hash::check($password, $student->password)) {
                Auth::guard('student')->login($student); // login using student guard
                $request->session()->regenerate();
                return redirect('/student/dashboard'); // redirect to student dashboard
            } else {
                $debug = 'Password mismatch';
            }
        } else {
            $debug = 'Student not found';
        }

        // ------------------------
        // 3️⃣ Failed login
        // ------------------------
        return back()->withErrors([
            'email' => 'Invalid credentials',
            'debug' => $debug
        ])->onlyInput('email');
    }




    // --- Show student registration form ---
    public function showRegisterForm()
    {
        return view('auth.student.register');
    }

    // --- Register student ---
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'class' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(3)],
            // New fields
            'father_name' => 'nullable|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'mother_name' => 'nullable|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'alt_guardian_name' => 'nullable|string|max:255',
            'alt_guardian_phone' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:5',
            'religion' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female,other',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ]);

        Student::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'class' => $validated['class'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'father_name' => $validated['father_name'] ?? null,
            'father_phone' => $validated['father_phone'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'mother_phone' => $validated['mother_phone'] ?? null,
            'alt_guardian_name' => $validated['alt_guardian_name'] ?? null,
            'alt_guardian_phone' => $validated['alt_guardian_phone'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'religion' => $validated['religion'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'present_address' => $validated['present_address'] ?? null,
            'permanent_address' => $validated['permanent_address'] ?? null,
        ]);


        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // --- Logout ---
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('student')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
