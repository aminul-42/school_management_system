@extends('frontend.layouts.app')

@section('title', 'ARM Academy')

@section('content')

    {{-- HOME SECTION --}}
    @include('frontend.sections.home')
    
   

    {{-- ABOUT SECTION --}}
    @include('frontend.sections.about')
    
    

    {{-- COURSES SECTION --}}
    @include('frontend.sections.courses')
    
    

    {{-- INSTRUCTOR SECTION --}}
    @include('frontend.sections.instructor')
    
    

    {{-- TESTIMONIALS SECTION --}}
    @include('frontend.sections.testimonial')
    
    

    {{-- CONTACT SECTION --}}
    @include('frontend.sections.contact')
    {{-- We typically skip the break after the last section (Contact) --}}

@endsection


<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.location.pathname === "/") {
        // Smooth scroll for nav links
        document.querySelectorAll('a.scroll-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href').replace('#', '');
                const target = document.getElementById(targetId);
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 50,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Smooth scroll for logo/brand
        const homeLogo = document.querySelector('a.scroll-home');
        if (homeLogo) {
            homeLogo.addEventListener('click', function(e) {
                const target = document.getElementById('home');
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 50,
                        behavior: 'smooth'
                    });
                }
            });
        }
    }
});
</script>