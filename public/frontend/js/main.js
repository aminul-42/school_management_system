(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Courses carousel
    $(".courses-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        loop: true,
        dots: false,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });


    // Team carousel
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
    });


    // Related carousel
    $(".related-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            }
        }
    });


    // Auto close navbar on mobile after click
    $(document).ready(function () {
        $('.navbar-nav a').on('click', function () {
            if ($('.navbar-toggler').is(':visible')) {
                $('.navbar-collapse').collapse('hide');
            }
        });
    });

})(jQuery);



    // Set active nav-link based on hash (for SPA-style navigation)
    function setActiveNav() {
        var hash = window.location.hash || "#home";
        document.querySelectorAll('#main-navbar .nav-link').forEach(function(link){
            link.classList.remove('active');
            if(link.getAttribute('href') === hash) {
                link.classList.add('active');
            }
        });
    }
    window.addEventListener('hashchange', setActiveNav);
    window.addEventListener('DOMContentLoaded', setActiveNav);

//Course Offer Countdown 

document.addEventListener("DOMContentLoaded", function() {
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(cd => {
        const expiry = new Date(cd.getAttribute('data-expiry')).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = expiry - now;

            if (distance < 0) {
                cd.innerHTML = "<span class='expired'>Offer Expired</span>";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            cd.querySelector(".days").textContent = days.toString().padStart(2, '0');
            cd.querySelector(".hours").textContent = hours.toString().padStart(2, '0');
            cd.querySelector(".minutes").textContent = minutes.toString().padStart(2, '0');
            cd.querySelector(".seconds").textContent = seconds.toString().padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});


//live search 


$('#courseSearch').on('keyup', function () {
    let query = $(this).val();
    if (query.length > 0) {
        $.get('{{ route("courses.search") }}', { query }, function(data) {
            let html = '';
            data.forEach(c => {
                html += `<a href="/course/${c.id}" class="list-group-item list-group-item-action">${c.title} - ${c.instructor || 'Unknown'} - ${c.language || 'N/A'}</a>`;
            });
            $('#searchResults').html(html).show();
        });
    } else {
        $('#searchResults').hide();
    }
});

$(document).click(function(e){
    if(!$(e.target).closest('#courseSearch, #searchResults').length){
        $('#searchResults').hide();
    }
});

function searchSubmit() {
    let query = $('#courseSearch').val();
    if(query) window.location.href = '{{ route("courses.search") }}?query=' + encodeURIComponent(query);
}




