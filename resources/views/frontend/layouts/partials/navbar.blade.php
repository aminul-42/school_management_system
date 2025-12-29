<div class="container-fluid p-0">
    <!-- Navbar: Uses a light background, subtle shadow, and fixed position -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 fixed-top shadow-sm-custom" id="main-nav-bar">
        <!-- Logo and Brand Name -->
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('frontend/images/logo.jpg')}}" alt="ARM Logo" class="navbar-logo">
            <!-- text-primary class is styled in CSS to be the ARM Green -->
            <span class="ml-2 font-weight-bold text-arm-primary">ARM ACADEMY</span>
        </a>

        <!-- Toggler for Mobile Menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links and Action Buttons -->
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <!-- Navigation Links -->
            <div class="navbar-nav mx-auto py-0" id="main-navbar">
                <a href="#home" class="nav-item nav-link">Home</a>
                <a href="#about" class="nav-item nav-link">About</a>
                <a href="#courses" class="nav-item nav-link">Courses</a>
                <a href="#instructors" class="nav-item nav-link">Instructors</a>
                <a href="#testimonial" class="nav-item nav-link">Testimonial</a>
                <a href="#contact" class="nav-item nav-link">Contact</a>
            </div>

            <!-- Auth/Action Buttons -->
            <div class="d-flex align-items-center gap-2 flex-column flex-lg-row">
                {{-- 1. Check if an Admin is logged in (using default 'web' guard) --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-dashboard">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">Logout</button>
                    </form>

                {{-- 2. Check if a Student is logged in (using 'student' guard) --}}
                @elseif(Auth::guard('student')->check())
                    <a href="{{ route('student.dashboard') }}" class="btn btn-dashboard">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        {{-- Logout clears all guards, so this is correct for both. --}}
                        <button type="submit" class="btn btn-logout">Logout</button>
                    </form>

                {{-- 3. No one is logged in --}}
                @else
                    <a href="{{ route('login') }}" class="btn btn-login mx-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register mx-2">Register</a>
                @endif
            </div>
        </div>
    </nav>
</div>

@push('styles')
    <style>
        /* Define Custom Color Variables for Easy Theming */
        :root {
            --arm-green: #009900;       /* Primary Academic Green (Slightly brighter for gradient start) */
            --arm-green-dark: #006600;  /* Darker Green for gradient end */
            --arm-red: #E63946;         /* Red for Logout/Danger (Slightly brighter) */
            --arm-red-dark: #C0303D;    /* Darker Red for gradient end */
            --arm-shadow: rgba(0, 0, 0, 0.08);
            --arm-text-color: #333;
        }

        /* Navbar Base Styling */
        .navbar {
            border-bottom: 3px solid var(--arm-green); /* More prominent academic border */
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 20px var(--arm-shadow); /* Increased shadow for lift */
        }

        /* Logo and Brand Text */
        .navbar .navbar-logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }
        .navbar-brand .text-arm-primary {
            color: var(--arm-green-dark) !important; /* Use a slightly darker color for static text */
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Navigation Links - Modern and Dynamic Hover */
        .navbar .nav-link {
            font-weight: 600;
            padding: 10px 15px !important;
            color: var(--arm-text-color);
            position: relative;
            transition: color 0.3s;
        }
        .navbar .nav-link:hover {
            color: var(--arm-green);
        }
        .navbar .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 3px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            /* Use a gradient for the underline for a smart effect */
            background: linear-gradient(90deg, var(--arm-green-dark), var(--arm-green));
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Slower, smoother transition */
        }
        .navbar .nav-link:hover::after {
            width: calc(100% - 30px); /* 100% width minus link padding */
        }

        /* Buttons Base Style */
        .btn {
            padding: 10px 24px;
            font-weight: 600;
            border-radius: 9999px; /* Fully rounded pill shape */
            transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1); /* Smooth transition for hover effects */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Slightly stronger initial shadow */
            border: none;
            text-decoration: none !important;
        }

        /* Green Action Buttons (Login, Register, Dashboard) */
        .btn-login, .btn-register, .btn-dashboard {
            /* Primary Green Gradient */
            background: linear-gradient(135deg, var(--arm-green), var(--arm-green-dark));
            color: #fff !important;
        }
        .btn-login:hover, .btn-register:hover, .btn-dashboard:hover {
            /* Reverse gradient and lift effect on hover */
            background: linear-gradient(135deg, var(--arm-green-dark), var(--arm-green));
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 153, 0, 0.6); /* Vibrant green shadow */
        }

        /* Logout Button (Accent Red Gradient) */
        .btn-logout {
            /* Red Gradient */
            background: linear-gradient(135deg, var(--arm-red), var(--arm-red-dark));
            color: #fff !important;
        }
        .btn-logout:hover {
            /* Reverse gradient and lift effect on hover */
            background: linear-gradient(135deg, var(--arm-red-dark), var(--arm-red));
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 10px 25px rgba(230, 57, 70, 0.6); /* Vibrant red shadow */
        }

        /* Mobile Responsiveness (Below 992px) */
        @media (max-width: 991px) {
            .navbar-collapse {
                /* Clean card-like appearance for the collapsed menu */
                background-color: #ffffff;
                border-radius: 12px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                margin-top: 10px;
                padding: 15px;
            }
            .navbar-nav {
                margin-bottom: 15px;
            }
            .navbar .nav-link {
                /* Full width links with a divider */
                width: 100%;
                margin: 5px 0;
                text-align: left;
                border-bottom: 1px solid #f0f0f0;
            }
            .navbar .nav-link:last-child {
                border-bottom: none;
            }
            .navbar .nav-link::after {
                /* Remove complex link hover effect on mobile for cleaner look */
                display: none;
            }
            .navbar .nav-link:hover {
                background-color: #f7f7f7;
                border-radius: 6px;
            }


            /* Full-width buttons for mobile, less aggressive hover animation */
            .navbar .btn {
                width: 100%;
                margin: 5px 0 !important;
                transform: none; /* Disable lift on mobile for better usability */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .navbar .btn:hover {
                 transform: none;
            }
            .btn-dashboard {
                margin-right: 0 !important;
            }
        }
    </style>
@endpush