@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 sm:p-8 md:p-10 animate-fade-slide-up">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold gradient-text text-center mb-6">Login To ARM</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 flex items-center gap-2 text-sm sm:text-base">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm sm:text-base">
                <ul class="list-disc pl-5 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4 sm:space-y-6">
            @csrf

            {{-- Email --}}
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 sm:py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Email Address">
            </div>

            {{-- Password --}}
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 sm:py-3 pl-10 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none transition duration-300"
                    placeholder="Password">
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full py-3 sm:py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 transform transition duration-300 text-sm sm:text-base">
                Login
            </button>
        </form>

        {{-- Footer Links --}}
        <div class="mt-6 text-center text-gray-600 text-xs sm:text-sm">
            Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Register</a>
        </div>
    </div>
</div>
@endsection
