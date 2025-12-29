<section id="home" class="relative flex items-center justify-center h-screen overflow-hidden">

    <div
        class="absolute inset-0 -z-20 bg-gradient-to-r from-pink-300 via-orange-200 to-lime-200 bg-fixed animate-gradientWave">
    </div>
    <div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <div class="relative z-10 text-center px-6 max-w-3xl space-y-10">
        <h1 class="typing-text text-3xl md:text-6xl font-extrabold text-black drop-shadow-xl">
            ARM ACADEMY
        </h1>

        <div class="text-lg md:text-2xl text-gray-100 font-semibold animate-fade-slide" id="quote">
            "Education is the passport to the future, for tomorrow belongs to those who prepare for it today."
        </div>

        <div class="flex flex-col md:flex-row justify-center gap-6 animate-fade-slide" style="animation-delay: 0.8s;">
            <a href="#courses"
                class="btn-gradient px-8 py-4 rounded-full text-lg font-bold shadow-lg transform transition-all duration-500 hover:scale-110 hover:shadow-2xl">
                Explore Courses
            </a>
            <a href="{{ route('register') }}"
                class="btn-gradient px-8 py-4 rounded-full text-lg font-bold shadow-lg transform transition-all duration-500 hover:scale-110 hover:shadow-2xl">
                Register Now
            </a>
        </div>
    </div>

    {{--
    ================================================================================
    THE CURVING SECTION BREAKER (INTERNAL DIV)
    - Absolute positioned to sit cleanly at the bottom of the section.
    ================================================================================
    --}}
    <div class="internal-section-breaker">
        <svg class="curve-divider" viewBox="0 0 1440 100" preserveAspectRatio="none">
            {{-- Path for the stylish, deep curve --}}
            <path class="curve-path" d="M0,70 C360,20 720,100 1440,70 L1440,100 L0,100 Z"></path>
        </svg>
    </div>

    <script>
        const quotes = [
            "Education is the passport to the future, for tomorrow belongs to those who prepare for it today.",
            "Learning is a treasure that will follow its owner everywhere.",
            "The beautiful thing about learning is nobody can take it away from you.",
            "Children are not things to be molded, but are people to be unfolded."
        ];

        let quoteIndex = 0;
        const quoteElement = document.getElementById('quote');

        setInterval(() => {
            quoteIndex = (quoteIndex + 1) % quotes.length;
            quoteElement.classList.remove('animate-fade-slide');
            void quoteElement.offsetWidth; // Restart animation
            quoteElement.textContent = quotes[quoteIndex];
            quoteElement.classList.add('animate-fade-slide');
        }, 6000);
    </script>

    <style>
        /* [Your existing styles for typing, gradientWave, fade-slide, etc., are here] */

        /* Typing Animation */
        .typing-text {
            overflow: hidden;
            border-right: .15em solid #fff;
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 4s steps(20, end) infinite alternate, blink-caret 0.75s step-end infinite;

        }

        @keyframes typing {
            0% {
                width: 0
            }

            50% {
                width: 100%
            }

            100% {
                width: 0
            }
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent
            }

            50% {
                border-color: #fff;
            }
        }

        /* Dynamic Gradient Waves */
        @keyframes gradientWave {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 50% 100%;
            }

            50% {
                background-position: 100% 50%;
            }

            75% {
                background-position: 50% 0%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-gradientWave {
            background-size: 400% 400%;
            animation: gradientWave 6s ease-in-out infinite;
        }

        /* Fade and Slide */
        @keyframes fade-slide {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-slide {
            animation: fade-slide 1.2s ease forwards;
        }

        /* Button Gradient */
        .btn-gradient {
            background: linear-gradient(90deg, #ff7eb3, #a855f7, #6366f1);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #f9a8d4, #c084fc, #818cf8);
        }

        /* ------------------------------------------- */
        /* INTERNAL CURVE BREAKER STYLES (REFINED) */
        /* ------------------------------------------- */

        .internal-section-breaker {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            /* INCREASE THIS HEIGHT TO ALLOW BIGGER WAVES */
            height: 200px;
            overflow: hidden;
            z-index: 5;
            pointer-events: none;
        }

        .curve-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .curve-path {
            /* FILL COLOR MUST MATCH THE BACKGROUND OF THE NEXT SECTION */
            fill: #ffffff;
            stroke: none;
            /* Use a high-quality CSS smooth transition for fallback/styling */
            transition: fill 0.5s;
        }
    </style>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- CURVE ANIMATION LOGIC ---

        const curveContainer = document.querySelector('.internal-section-breaker');

        if (curveContainer) {
            const path = curveContainer.querySelector('.curve-path');

            // 1. Define the core SVG animation logic
            const animateElement = document.createElementNS("http://www.w3.org/2000/svg", "animate");

            // Define the shape changes for a deeper, slower wave
            animateElement.setAttribute('attributeName', 'd');
            animateElement.setAttribute('values',
                // Shape 1 (More Extreme Top Dip)
                // Changed 70 -> 80, 20 -> 5, and 100 -> 120
                'M0,80 C360,5 720,120 1440,80 L1440,100 L0,100 Z; ' +
                // Shape 2 (More Extreme Bottom Dip)
                // Changed 70 -> 80, 100 -> 5, and 20 -> 120
                'M0,80 C360,120 720,5 1440,80 L1440,100 L0,100 Z; ' +
                // Return to Shape 1
                'M0,80 C360,5 720,120 1440,80 L1440,100 L0,100 Z'
            );
            animateElement.setAttribute('dur', '8s'); // Keeping a slower duration for smoothness
            animateElement.setAttribute('repeatCount', 'indefinite');

            // 2. Setup the Intersection Observer (The "Smart" performance part)
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Start animation when the section is visible
                        path.appendChild(animateElement);
                    } else {
                        // Stop animation when out of view (saves CPU!)
                        if (path.contains(animateElement)) {
                            path.removeChild(animateElement);
                        }
                    }
                });
            }, {
                rootMargin: '0px',
                threshold: 0.1
            });

            // Observe the main home section
            observer.observe(document.getElementById('home'));
        }
    });
</script>