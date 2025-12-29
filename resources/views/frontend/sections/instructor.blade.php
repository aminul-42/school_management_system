<section id="instructor" class="py-20 relative text-center overflow-hidden">
    {{-- Fixed Gradient Background --}}
    <div class="absolute inset-0 -z-20 bg-linear-to-r from-yellow-200 via-pink-300 to-purple-300 bg-fixed animate-gradientWave"></div>
    <div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <h2 class="text-5xl md:text-6xl font-extrabold gradient-text mb-12">Meet Our Teachers</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-4xl mx-auto px-4">
        <!-- Instructor 1 -->
        <div class="p-6 rounded-3xl bg-white shadow-lg hover:scale-105 transition transform">
            <img src="{{ asset('frontend/images/ARM.jpg') }}" alt="MD ASIF RAHAMAN MIM" class="w-24 mx-auto mb-4 animate-float">
            <h5 class="text-2xl font-bold text-black-600">MD ASIF RAHAMAN MIM</h5>
            <p class="text-gray-600">Chief Instructor & Managing Director</p>
        </div>

        <!-- Instructor 2 -->
        <div class="p-6 rounded-3xl bg-white shadow-lg hover:scale-105 transition transform">
            <img src="{{ asset('frontend/images/ARM2.jpg') }}" alt="REFAH TASNIA" class="w-24 mx-auto mb-4 animate-float">
            <h5 class="text-2xl font-bold text-black-600">REFAH TASNIA</h5>
            
            <p class="text-gray-600">BA(Hons.)in English, University Of Rajshahi</p>
            <p class="text-gray-600">Bachelor in Dawah and Islamic Studies , Islamic online Madrasah-IOM </p>
            <p class="text-gray-600">Lead Female Instructor, ARM English Academy</p>
        </div>
    </div>
</section>
