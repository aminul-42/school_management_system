@extends('frontend.layouts.app')

@section('title', $course->title)

@section('content')
<section class="pt-28 pb-10 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        {{-- Page Heading --}}
        <h2 class="text-6xl font-bold mb-8 animate-gradient-text">Course Details</h2>

        <div class="flex flex-col lg:flex-row gap-10">
            
            {{-- Course Image --}}
            <div class="lg:w-1/2 relative">
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="rounded-3xl w-full h-auto object-cover shadow-lg">

                {{-- Floating Offer Badge --}}
                @if($course->offer_price && $course->offer_expires_at > now())
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-6 py-3 rounded-full shadow-xl flex flex-col items-center animate-float-badge">
                        <span class="text-lg font-bold">OFFER TIME LEFT!</span>
                        <span id="offer-countdown" class="mt-2 text-xl font-extrabold">Loading...</span>
                    </div>
                @endif
            </div>

            {{-- Course Info --}}
            <div class="lg:w-1/2 flex flex-col gap-6">
                {{-- Title --}}
                <h1 class="text-4xl font-extrabold animate-gradient-text">{{ $course->title }}</h1>

                {{-- Rating --}}
                <div class="flex items-center gap-4">
                    <span class="text-yellow-500">
                        @for ($i = 0; $i < floor($course->rating); $i++)
                            <i class="fa fa-star"></i>
                        @endfor
                        @if($course->rating - floor($course->rating) >= 0.5)
                            <i class="fa fa-star-half-alt"></i>
                        @endif
                    </span>
                    <span class="text-gray-500 text-sm">({{ $course->reviews }} Reviews)</span>
                </div>

                {{-- Instructor --}}
                <div class="bg-white p-4 rounded-xl shadow-md">
                    <p class="text-gray-500 text-sm">Instructor:</p>
                    <p class="font-bold">{{ $course->instructor }}</p>
                </div>

                {{-- Meta Info --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <p class="text-gray-500 text-sm">Lectures</p>
                        <p class="font-bold">{{ $course->lectures_count }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <p class="text-gray-500 text-sm">Duration</p>
                        <p class="font-bold">{{ $course->duration }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <p class="text-gray-500 text-sm">Skill Level</p>
                        <p class="font-bold">{{ $course->skill_level }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-md">
                        <p class="text-gray-500 text-sm">Language</p>
                        <p class="font-bold">{{ $course->language }}</p>
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-2xl font-bold mb-4">Course Description</h2>
                    <p class="text-gray-700">{{ $course->description }}</p>
                </div>

                {{-- Pricing --}}
                <div class="flex items-center gap-4 mt-2">
                    @if($course->offer_price && $course->offer_expires_at > now())
                        <p class="text-gray-400 line-through text-xl">${{ $course->fee }}</p>
                        <p class="text-red-500 font-extrabold text-2xl">${{ $course->offer_price }}</p>
                    @else
                        <p class="text-gray-800 font-extrabold text-2xl">${{ $course->fee }}</p>
                    @endif
                </div>

                {{-- CTA Button --}}
                <a href="{{ route('register') }}" class="btn-gradient inline-block w-full py-3 mt-4 text-center rounded-full font-bold text-white text-lg">
                    Enroll Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Floating bounce animation for badge */
@keyframes float-badge {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.animate-float-badge {
    animation: float-badge 2s ease-in-out infinite;
}
</style>
@endpush

@push('scripts')
@if($course->offer_price && $course->offer_expires_at > now())
<script>
document.addEventListener('DOMContentLoaded', function(){
    const countdownEl = document.getElementById('offer-countdown');
    const offerEnd = new Date("{{ $course->offer_expires_at }}").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = offerEnd - now;

        if(distance < 0){
            countdownEl.innerText = "Expired";
            countdownEl.parentElement.classList.remove('bg-red-600');
            countdownEl.parentElement.classList.add('bg-gray-400');
            clearInterval(interval);
            return;
        }

        const days = Math.floor(distance / (1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
        const minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
        const seconds = Math.floor((distance % (1000*60)) / 1000);

        countdownEl.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    }

    updateCountdown();
    const interval = setInterval(updateCountdown, 1000);
});
</script>
@endif
@endpush
