<section id="testimonial" class="py-20 relative text-center overflow-hidden">
    {{-- Fixed Gradient Background --}}
      <div class="absolute inset-0 -z-20 bg-gradient-to-r from-pink-300 via-orange-200 to-lime-200 bg-fixed animate-gradientWave"></div>
<div class="absolute inset-0 -z-10 bg-black/20 backdrop-blur-sm"></div>

    <h2 class="text-5xl md:text-6xl font-extrabold gradient-text mb-12">
        Testimonial
    </h2>

    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 px-6">
       

        {{-- New Testimonials --}}
        <div class="p-6 bg-white rounded-3xl shadow-lg hover:scale-105 transition transform">
            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
            <p class="text-gray-600 italic mb-3">আমি খুব ব্যস্ত ছিলাম কোচিং সেন্টারে যেতে পারছিলাম না, তারপর ARM ENGLISH ACADEMY তে অনলাইন
                কোর্স করলাম, রেকর্ড করা ক্লাস এবং প্রশিক্ষকের সহজ পদ্ধতি আমাকে রাজশাহী বিশ্ববিদ্যালয়ে
                ভর্তির সুযোগ পেতে সাহায্য করেছে।
            </p>
            <div class="flex items-center mt-4">
                <img class="w-12 h-12 rounded-full mr-4 object-cover" src="{{ asset('frontend/images/testimonial-2.jpg') }}" alt="Mominul Islam">
                <div class="text-left">
                    <h5 class="font-bold">Mominul Islam</h5>
                    <span class="text-gray-500 text-sm">Admission Batch</span>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-3xl shadow-lg hover:scale-105 transition transform">
            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
            <p class="text-gray-600 italic mb-3">আমি ইংরেজিতে খুব দুর্বল ছিলাম। কিন্তু ARM English Academy তে দুই মাসের প্রস্তুতি আমার
                কাঙ্ক্ষিত ফলাফল পেতে সাহায্য করেছে।
            </p>
            <div class="flex items-center mt-4">
                <img class="w-12 h-12 rounded-full mr-4 object-cover" src="{{ asset('frontend/images/testimonial-1.jpg') }}" alt="Fabiha Zannat">
                <div class="text-left">
                    <h5 class="font-bold">Fabiha Zannat</h5>
                    <span class="text-gray-500 text-sm">SSC Batch 2022</span>
                </div>
            </div>
        </div>
    </div>
</section>
