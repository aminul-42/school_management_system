<header class="fixed w-full z-50 top-0">
    <div
        class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4 bg-white/70 backdrop-blur-md shadow-md rounded-b-lg">

        {{-- Logo + Animated Brand Name --}}
        <a href="{{ request()->is('/') ? '#home' : url('/#home') }}" class="flex items-center gap-3 scroll-home">
            <img src="/frontend/images/logo.jpg" alt="ARM Kids Academy" class="w-14 h-14 object-contain">
            <span class="text-2xl md:text-3xl font-extrabold gradient-text">ARM Academy</span>
        </a>

        {{-- Menu --}}
        <div class="relative">
            <button id="menu-btn"
                class="text-3xl p-2 rounded-lg btn-gradient shadow-lg hover:scale-110 transition-transform">☰</button>

            <div id="nav-links"
                class="absolute right-0 mt-2 w-64 bg-black/90 text-white backdrop-blur-md rounded-lg opacity-0 pointer-events-none transform -translate-y-3 transition-all duration-300 z-50">
                <nav class="flex flex-col p-4 space-y-3">
                    @foreach(['home', 'about', 'courses', 'instructor', 'testimonial', 'contact'] as $link)
                        <a href="{{ request()->is('/') ? '#' . $link : url('/#' . $link) }}"
                            class="hover:underline hover:scale-105 transition-all scroll-link">
                            {{ ucfirst($link) }}
                        </a>
                    @endforeach

                    <hr class="border-gray-400/50">

                    {{-- Auth Buttons --}}
                    <div class="flex flex-col gap-2">
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}"
                                class="btn-gradient px-3 py-2 rounded-lg text-center">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-gradient px-3 py-2 rounded-lg w-full">Logout</button>
                            </form>
                        @elseif(Auth::guard('student')->check())
                            <a href="{{ route('student.dashboard') }}"
                                class="btn-gradient px-3 py-2 rounded-lg text-center">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-gradient px-3 py-2 rounded-lg w-full">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-gradient px-3 py-2 rounded-lg text-center">Login</a>
                            <a href="{{ route('register') }}"
                                class="btn-gradient px-3 py-2 rounded-lg text-center">Register</a>
                        @endif
                    </div>
                </nav>
            </div>
        </div>
    </div>

    {{-- Header JS --}}
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const navLinks = document.getElementById('nav-links');

        menuBtn.addEventListener('mouseenter', () => {
            navLinks.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-3');
            navLinks.classList.add('opacity-100', 'translate-y-0');
        });

        navLinks.addEventListener('mouseleave', () => {
            navLinks.classList.add('opacity-0', 'pointer-events-none', '-translate-y-3');
            navLinks.classList.remove('opacity-100', 'translate-y-0');
        });
    </script>
</header>