<section id="contact" class="py-20 relative text-center overflow-hidden">
    {{-- Fixed Gradient Background --}}
<div class="absolute inset-0 -z-20 bg-gradient-to-r from-yellow-200 via-pink-300 to-purple-300 bg-fixed animate-gradientWave"></div>
    <div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-5xl md:text-6xl font-extrabold gradient-text mb-12">Contact With Us</h2>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            {{-- Contact Info Cards --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- Card 1 --}}
                <div class="flex items-center p-6 rounded-3xl bg-white/90 backdrop-blur-md shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-600 text-white mr-4 transition transform hover:scale-110">
                        <!-- Heroicon: Location Marker -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 11c1.1046 0 2-.8954 2-2s-.8954-2-2-2-2 .8954-2 2 .8954 2 2 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 22s8-4.5 8-10-3.582-8-8-8-8 3.582-8 8 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-lg">Our Location</h4>
                        <p class="text-gray-700">Infront of Rajshahi Govt Women's College, Rajshahi</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="flex items-center p-6 rounded-3xl bg-white/90 backdrop-blur-md shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-purple-600 text-white mr-4 transition transform hover:scale-110">
                        <!-- Heroicon: Phone -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V9a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11l6 6m0 0l-3 3m3-3H10"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-lg">Call Us</h4>
                        <p class="text-gray-700">01737347373</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="flex items-center p-6 rounded-3xl bg-white/90 backdrop-blur-md shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                    <div class="w-14 h-14 flex items-center justify-center rounded-full bg-yellow-500 text-white mr-4 transition transform hover:scale-110">
                        <!-- Heroicon: Mail -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 0v8a2 2 0 002 2h14a2 2 0 002-2V8m-18 0L12 13l9-5"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-lg">Email Us</h4>
                        <p class="text-gray-700">armenglishacademy@gmail.com</p>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-7 bg-white/90 backdrop-blur-md rounded-3xl p-6 lg:p-10 shadow-lg transform transition hover:scale-105 hover:shadow-2xl">
                <h6 class="text-secondary uppercase tracking-wider mb-2">Need Help?</h6>
                <h2 class="text-3xl sm:text-4xl font-extrabold gradient-text mb-8">Send Us A Message</h2>

                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Your Name" required
                            class="w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-pink-400 focus:outline-none transition duration-300 hover:shadow-lg">
                        <input type="email" placeholder="Your Email" required
                            class="w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-300 hover:shadow-lg">
                    </div>
                    <input type="text" placeholder="Subject" required
                        class="w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-400 focus:outline-none transition duration-300 hover:shadow-lg">
                    <textarea placeholder="Message" rows="5" required
                        class="w-full p-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition duration-300 hover:shadow-lg"></textarea>
                    <button type="submit"
                        class="btn-gradient px-6 py-3 rounded-full text-lg font-bold w-full sm:w-auto hover:scale-105 transform transition duration-300 shadow-lg hover:shadow-2xl">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
