<section id="courses" class="py-20 relative overflow-hidden">
    <!-- Fixed Gradient Background -->
   <div class="absolute inset-0 -z-20 bg-gradient-to-r from-pink-300 via-orange-200 to-lime-200 bg-fixed animate-gradientWave"></div>
<div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <!-- Title -->
    <div class="relative z-10 text-center mb-12">
        <h2 class="text-5xl md:text-6xl font-extrabold gradient-text mb-12 ">Our Courses</h2>
        
    </div>

    <!-- Slider -->
    <div class="relative max-w-7xl mx-auto px-6 overflow-hidden z-10">
        <div id="courses-slider" class="flex gap-6 transition-transform duration-500">
            @foreach($courses as $course)
                <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 rounded-3xl shadow-lg transform transition-all duration-500 hover:scale-105 hover:shadow-2xl bg-white">
                    <img class="w-full h-48 object-cover rounded-t-3xl" src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                    <div class="p-4 text-center">
                        <h3 class="text-xl font-bold mb-2">{{ $course->title }}</h3>

                        @if($course->offer_price && $course->offer_expires_at > now())
                            <p class="text-gray-400 line-through mb-1">${{ $course->fee }}</p>
                            <p class="text-red-500 font-bold text-lg">${{ $course->offer_price }}</p>
                        @else
                            <p class="text-gray-800 font-bold text-lg">${{ $course->fee }}</p>
                        @endif

                        <a href="{{ route('course.detail', ['id' => $course->id]) }}" class="btn-gradient inline-block w-full py-2 mt-3 rounded-full font-bold text-center">
                            Course Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Slider Arrows -->
        <button id="prev-btn" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-lg hover:bg-white transition text-2xl">&#10094;</button>
        <button id="next-btn" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/80 rounded-full p-2 shadow-lg hover:bg-white transition text-2xl">&#10095;</button>
    </div>

    <script>
        const slider = document.getElementById('courses-slider');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const slides = Array.from(slider.children);
        const totalSlides = slides.length;
        const gap = 24;
        let index = 0;

        const visibleSlidesDesktop = 3;
        for(let i=0; i<visibleSlidesDesktop; i++){
            slider.appendChild(slides[i].cloneNode(true));
        }

        function getVisibleSlides() {
            if(window.innerWidth >= 768) return 3;
            if(window.innerWidth >= 640) return 2;
            return 1;
        }

        function updateSlider() {
            const visible = getVisibleSlides();
            const slideWidth = slides[0].offsetWidth + gap;
            slider.style.transform = `translateX(-${index * slideWidth}px)`;
        }

        function nextSlide() {
            const visible = getVisibleSlides();
            index++;
            updateSlider();
            if(index >= totalSlides) {
                setTimeout(() => {
                    slider.style.transition = 'none';
                    index = 0;
                    updateSlider();
                    slider.offsetHeight;
                    slider.style.transition = 'transform 0.5s ease';
                }, 500);
            }
        }

        function prevSlide() {
            const visible = getVisibleSlides();
            index--;
            if(index < 0) {
                index = totalSlides - getVisibleSlides();
                slider.style.transition = 'none';
                updateSlider();
                slider.offsetHeight;
                slider.style.transition = 'transform 0.5s ease';
            } else {
                updateSlider();
            }
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        let autoPlay = setInterval(nextSlide, 3000);
        slider.addEventListener('mouseenter', () => clearInterval(autoPlay));
        slider.addEventListener('mouseleave', () => autoPlay = setInterval(nextSlide, 3000));

        window.addEventListener('resize', updateSlider);
        window.addEventListener('load', updateSlider);
    </script>

    <style>
        .btn-gradient {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover { transform: scale(1.05); box-shadow: 0 8px 25px rgba(0,0,0,0.2); }
    </style>
</section>
