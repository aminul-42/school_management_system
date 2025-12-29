<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Student Panel') - ARM ENGLISH ACADEMY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    <style>
        /* --- PLAYFUL COLOR PALETTE & VARIABLES (Retained) --- */
        :root {
            --primary-blue: #5b6af0;
            /* Main playful blue */
            --primary-dark: #3a47c0;
            /* Darker blue for sidebar */
            --accent-yellow: #ffc94b;
            /* Bright accent for hover/active */
            --white: #ffffff;
            --muted: #8c8c8c;
            --success: #38c172;
            --danger: #ef5350;
            --background: #f0f8ff;
            /* Light, soft background blue */
            --radius: 16px;
            /* Increased radius for a softer look */
            --transition: 0.3s ease-out;
            --topbar-height: 70px;
        }

        /* --- GLOBAL & BASE LAYOUT --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body.layout {
            background: var(--background);
            color: #333;
            min-height: 100vh;
            display: flex;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: var(--white);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            gap: 16px;
            transition: transform var(--transition);
            z-index: 1000;
            /* Added a strong right shadow for depth when open on desktop */
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
        }

        .brand a {
            text-decoration: none;
            display: block;
        }

        .brand-name {
            font-weight: 800;
            font-size: 1.35rem;
            /* Increased size for prominence */
            white-space: nowrap;
            color: var(--accent-yellow);
            display: block;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
            /* Stronger shadow */
            padding: 10px 8px;
            text-align: center;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: var(--radius);
            color: var(--white);
            text-decoration: none;
            font-weight: 700;
            /* Bolder text */
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            /* Slightly darker initial shadow */
        }

        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 1.2rem;
            /* Larger icon */
        }

        /* Active/Hover: More pronounced effect */
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.25);
            /* Brighter hover background */
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .menu-item.active {
            background: var(--accent-yellow);
            color: var(--primary-dark);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
            /* Big, fun shadow on active */
            transform: scale(1.03);
            /* Bigger pop out on active */
        }

        .sidebar-footer {
            margin-top: auto;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            padding-top: 10px;
        }

        /* --- MAIN CONTENT AREA & TOPBAR --- */
        .main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left var(--transition);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--topbar-height);
            padding: 0 28px;
            background: var(--white);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 500;
            border-bottom-left-radius: var(--radius);
            border-bottom-right-radius: var(--radius);
        }

        .page-title {
            font-size: 1.6rem;
            /* Slightly larger title */
            font-weight: 800;
            color: var(--primary-blue);
            margin: 0 auto;
            flex-grow: 1;
            text-align: center;
            position: relative;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Typing indicator removed for cleaner look, kept bold text */

        .top-left,
        .top-right {
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 510;
        }

        /* Mobile Menu Icon Style */
        .btn-icon {
            background: var(--primary-blue);
            border: none;
            color: var(--white);
            font-size: 1.4rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all var(--transition);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-icon:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }

        /* User Info (Desktop) */
        .user-meta {
            text-align: right;
        }

        .user-meta strong {
            display: block;
            color: var(--primary-dark);
            font-size: 1.1rem;
            font-weight: 700;
        }

        .role {
            color: var(--muted);
            font-size: 0.85rem;
        }

        /* Smart Logout Button */
        .btn-smart-logout {
            background: var(--danger);
            color: var(--white);
            border: none;
            padding: 10px 18px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(239, 83, 80, 0.4);
        }

        .btn-smart-logout:hover {
            background: #c63733;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(239, 83, 80, 0.5);
        }

        .btn-smart-logout i {
            font-size: 1rem;
            margin-right: 5px;
        }


        /* --- CONTENT & FOOTER --- */
        .content {
            padding: 30px;
            width: 100%;
            flex: 1;
        }

        /* --- CONTENT CARDS (New Core Component for Kid-Friendly Layout) --- */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            /* Large radius for soft edges */
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            /* Soft, noticeable, elevated shadow */
            border: 1px solid #e0eaf6;
            /* Very subtle border */
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 20px;
            border-bottom: 4px solid var(--accent-yellow);
            /* Fun accent bar */
            display: inline-block;
            padding-bottom: 5px;
        }

        /* Forms and Input Styling within content */
        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 1rem;
            width: 100%;
            border: 2px solid #ddd;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 4px rgba(91, 106, 240, 0.25);
            /* Soft focus ring */
        }

        .btn-primary {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            font-weight: 700;
            cursor: pointer;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(91, 106, 240, 0.4);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(91, 106, 240, 0.5);
        }

        .footer {
            margin-top: auto;
            padding: 15px 28px;
            display: flex;
            justify-content: space-between;
            color: var(--muted);
            border-top: 1px solid #e0eaf6;
            background: var(--white);
            font-size: 0.85rem;
            font-weight: 600;
            border-top-left-radius: var(--radius);
            border-top-right-radius: var(--radius);
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.05);
        }

        .mobile-only {
            display: none;
        }

        .desktop-only {
            display: block;
        }

        /* --- FLASH MESSAGES (Refined) --- */
        .flash-message {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: var(--radius);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            opacity: 1;
            transition: opacity 0.5s ease-out, transform 0.3s ease-out;
            transform: translateY(0);
        }

        .flash-message i {
            font-size: 1.5rem;
        }

        .flash-message.success {
            background: #e6fff0;
            color: #1e8449;
            border: 2px solid var(--success);
        }

        .flash-message.danger {
            background: #fff0f0;
            color: #b00020;
            border: 2px solid var(--danger);
        }

        /* --- LOADER & CONFIRMATION MODALS (Retained logic) --- */

        .loader-overlay,
        .confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Slightly darker overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            display: none;
        }

        .loader {
            border: 8px solid var(--primary-blue);
            border-top: 8px solid var(--accent-yellow);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .confirm-box {
            background: var(--white);
            padding: 30px;
            /* Increased padding */
            border-radius: var(--radius);
            text-align: center;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border: 5px solid var(--accent-yellow);
            /* Thicker border */
            transform: scale(1);
            animation: bounceIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes bounceIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .confirm-box h3 {
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .confirm-box p {
            color: #555;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .confirm-actions button {
            padding: 12px 22px;
            margin: 5px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
        }

        .btn-confirm {
            background: var(--danger);
            color: var(--white);
            box-shadow: 0 4px 6px rgba(239, 83, 80, 0.4);
        }

        .btn-confirm:hover {
            background: #c63733;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #555;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel:hover {
            background: #cccccc;
            transform: translateY(-2px);
        }


        /* --- MOBILE RESPONSIVENESS (max-width: 900px) --- */
        @media(max-width: 900px) {

            /* Sidebar Toggle */
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 0 15px;
                height: 60px;
                border-radius: 0;
            }

            .page-title {
                font-size: 1.2rem;
                max-width: 50%;
            }

            .mobile-only {
                display: inline-flex;
            }

            .desktop-only {
                display: none;
            }

            .user-info {
                display: none;
            }

            /* Minimal Logout Button */
            .btn-smart-logout {
                padding: 10px;
                font-size: 1.2rem;
                border-radius: 50%;
                /* Make it a circle on mobile */
                box-shadow: 0 2px 4px rgba(239, 83, 80, 0.5);
            }

            .btn-smart-logout i {
                margin: 0;
            }

            .btn-smart-logout span {
                display: none;
            }

            /* Content & Footer */
            .content {
                padding: 20px 15px;
            }

            .footer {
                padding: 10px 15px;
                flex-direction: column;
                text-align: center;
                gap: 5px;
                font-size: 0.7rem;
                border-radius: 0;
            }
        }

        /* Add overlay when sidebar is open on mobile */
        body.sidebar-open::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            pointer-events: auto;
        }
    </style>

    @stack('styles')
</head>

<body class="layout">

    <div id="loader" class="loader-overlay">
        <!-- Fun Loader Colors -->
        <div class="loader"></div>
    </div>

    {{-- The delete confirmation modal will be dynamically inserted here by JavaScript --}}

    <aside id="sidebar" class="sidebar">
        <div class="brand">
            <a href="{{ route('student.dashboard') }}">
                <span class="brand-name">ARM ACADEMY</span>
            </a>
        </div>

        <nav class="menu">
            {{-- Homepage link: Active when path is exactly '/' --}}
            <a href="/" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                <i class="fa fa-home"></i><span>Homepage</span>
            </a>

            {{-- Dashboard link: Active when route is 'student.dashboard' --}}
            <a href="{{ route('student.dashboard') }}"
                class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i><span>Dashboard</span>
            </a>

            {{-- Course Link: Changed icon to fa-book-open for clarity/standard use --}}
            <a href="{{ route('student.courses') }}"
                class="menu-item {{ request()->routeIs('student.courses') || request()->routeIs('student.courses.edit') ? 'active' : '' }}">
                <i class="fa fa-book-open"></i><span>My Courses</span>
            </a>

            <a href="{{ route('student.notices') }}"
                class="menu-item {{ request()->routeIs('student.notices') ? 'active' : '' }}">
                <i class="fa fa-bullhorn"></i><span>Notices</span>
                
            </a>


            <a href="{{ route('student.profile') }}"
                class="menu-item {{ request()->routeIs('student.profile') || request()->routeIs('student.profile.edit') ? 'active' : '' }}">
              
                <i class="fa fa-user-circle"></i><span>My Profile</span>
            </a>


            <a href="#" class="menu-item"><i class="fa fa-cog"></i><span>Settings</span></a>
        </nav>

        <div class="sidebar-footer">
            <small>© {{ date('Y') }} ARM</small>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="top-left">
                <button id="mobileMenuBtn" class="btn-icon mobile-only"><i class="fa fa-bars"></i></button>
            </div>

            <h1 class="page-title">@yield('title', 'Dashboard')</h1>

            <div class="top-right">
                <div class="user-info desktop-only">
                    <div class="user-meta">
                        <strong>{{ Auth::guard('student')->user()->name ?? Auth::guard('web')->user()->name ?? 'Guest User' }}</strong>
                        <small class="role">
                            {{ Auth::guard('student')->check() ? 'Student' : (Auth::guard('web')->check() ? 'Admin' : 'Dashboard') }}
                        </small>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button class="btn btn-smart-logout" type="submit">
                        <i class="fa fa-sign-out-alt"></i>
                        <span class="desktop-only">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="content">

            {{-- Blade Alert Messages --}}
            @if(session('success'))
                <div id="flashSuccess" class="flash-message success">
                    <i class="fa fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('danger'))
                <div id="flashDanger" class="flash-message danger">
                    <i class="fa fa-exclamation-triangle"></i>
                    <span>{{ session('danger') }}</span>
                </div>
            @endif

            {{-- IMPORTANT: All page content should be wrapped in the .card class for a professional, kid-friendly look.
            --}}
            {{-- Example: <div class="card">
                <h2 class="card-title">My Progress</h2>...
            </div> --}}
            @yield('content')

        </main>

        <footer class="footer">
            <div>ARM ENGLISH ACADEMY · Student Panel</div>
        </footer>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const loader = document.getElementById('loader');

        // Function to set up automatic dismissal for flash messages
        function setupFlashMessageDismissal(id) {
            const flashMessage = document.getElementById(id);
            if (flashMessage) {
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    flashMessage.style.opacity = '0';
                    flashMessage.style.transform = 'translateY(-10px)';
                    // Remove fully after transition finishes (0.5s transition time)
                    setTimeout(() => {
                        flashMessage.remove();
                    }, 500);
                }, 5000);
            }
        }

        // Mobile toggle
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        });

        // Click outside to close sidebar
        document.addEventListener('click', e => {
            if (window.innerWidth < 900) {
                const isClickInsideSidebar = sidebar.contains(e.target);
                const isClickOnMenuButton = mobileMenuBtn.contains(e.target);

                if (!isClickInsideSidebar && !isClickOnMenuButton && sidebar.classList.contains('open')) {
                    sidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                }
            }
        });

        // Hide sidebar on menu item click (on mobile)
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 900) {
                    sidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });

        // Show loader for all forms EXCEPT delete forms
        document.querySelectorAll('form:not(.deleteForm)').forEach(form => {
            form.addEventListener('submit', () => { loader.style.display = 'flex'; });
        });

        // Global Delete Confirmation (Uses custom modal instead of alert/confirm)
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.deleteForm').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const existingModal = document.querySelector('.confirm-overlay');
                    if (existingModal) existingModal.remove();

                    const modal = document.createElement('div');
                    modal.classList.add('confirm-overlay');
                    modal.innerHTML = `
                        <div class="confirm-box">
                            <h3>Confirm Delete</h3>
                            <p>Are you sure you want to delete this item? This action cannot be undone!</p>
                            <div class="confirm-actions">
                                <button type="button" class="btn-confirm">Yes, Delete</button>
                                <button type="button" class="btn-cancel">Cancel</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);

                    modal.querySelector('.btn-cancel').addEventListener('click', () => modal.remove());

                    modal.querySelector('.btn-confirm').addEventListener('click', () => {
                        modal.remove();
                        loader.style.display = 'flex';
                        form.submit();
                    });
                });
            });

            // Set up auto-dismissal for all flash messages
            setupFlashMessageDismissal('flashSuccess');
            setupFlashMessageDismissal('flashDanger');
        });
    </script>

    @stack('scripts')
</body>

</html>