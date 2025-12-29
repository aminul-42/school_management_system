<section id="about" class="relative py-20 px-4 overflow-hidden">

    <!-- Background Gradients -->
    <div class="absolute inset-0 -z-20 bg-gradient-to-r from-yellow-200 via-pink-300 to-purple-300 bg-fixed animate-gradientWave"></div>
    <div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <!-- Section Title -->
    <div class="text-center mb-16 relative z-10">
        <h2 class="text-5xl md:text-6xl font-extrabold gradient-text mb-6">
            About Us
        </h2>
        <p class="mt-4 text-lg md:text-xl text-gray-800 max-w-2xl mx-auto">
            We nurture curiosity, creativity, and learning in children. Our mission is to make education fun and engaging!
        </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto relative z-10">
        @php
            $cards = [
                ['icon' => '📚', 'title' => 'Innovative Learning', 'desc' => 'Hands-on, playful methods that make learning fun.'],
                ['icon' => '🧠', 'title' => 'Critical Thinking', 'desc' => 'Encouraging problem-solving and curiosity.'],
                ['icon' => '🎨', 'title' => 'Creative Skills', 'desc' => 'Fostering art, music, and imagination.'],
                ['icon' => '🤝', 'title' => 'Social Growth', 'desc' => 'Teamwork and social skills development.'],
                ['icon' => '💡', 'title' => 'STEM Exploration', 'desc' => 'Science, technology, engineering, and math made fun.'],
                ['icon' => '🌱', 'title' => 'Personal Growth', 'desc' => 'Building confidence and emotional intelligence.'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white/90 rounded-2xl shadow-xl p-6 text-center transform transition-transform duration-500 hover:scale-105 hover:shadow-2xl relative overflow-hidden">
                
                <!-- Floating Icon -->
                <div class="text-6xl mb-4 animate-float">
                    {{ $card['icon'] }}
                </div>

                <!-- Animated Gradient Title -->
                <h3 class="text-2xl font-bold mb-2 animate-gradient-text">
                    {{ $card['title'] }}
                </h3>

                <!-- Description -->
                <p class="text-gray-800">
                    {{ $card['desc'] }}
                </p>
            </div>
        @endforeach
    </div>

    <!-- Section Animations -->
    <style>
        /* Floating card icons */
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Gradient text animation */
        .animate-gradient-text {
            background: linear-gradient(90deg, #ff9a00, #f43b47, #00c6ff, #0072ff);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width:768px) {
            h2 { font-size: 2.5rem; }
        }
    </style>
</section>
