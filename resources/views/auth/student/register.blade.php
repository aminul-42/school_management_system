@extends('frontend.layouts.app')

@section('title', 'Student Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl p-6 sm:p-8 md:p-10 animate-fade-slide-up">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold gradient-text text-center mb-8">Student Register</h1>

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-6 text-sm sm:text-base">
                <ul class="list-disc pl-5 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @csrf

            {{-- Full Name --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Full Name">
            </div>

            {{-- Email --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Email Address">
            </div>

            {{-- Class --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-school"></i>
                </span>
                <input type="text" name="class" id="class" value="{{ old('class') }}" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Class">
            </div>

            {{-- Phone Number --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-phone"></i>
                </span>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Phone Number">
            </div>

            {{-- Password --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Password">
            </div>

            {{-- Confirm Password --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Confirm Password">
            </div>

            {{-- Submit Button (full width) --}}
            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full py-3 sm:py-3 bg-linear-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 transform transition duration-300 text-sm sm:text-base">
                    Register
                </button>
            </div>
        </form>

        {{-- Footer Link --}}
        <div class="mt-6 text-center text-gray-600 text-xs sm:text-sm">
            Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Login</a>
        </div>
    </div>
</div>
@endsection
