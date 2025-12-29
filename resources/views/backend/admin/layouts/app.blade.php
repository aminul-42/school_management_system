<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin Panel') - ARM ENGLISH ACADEMY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
      <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
   <style>
    :root {
    --blue: #1e90ff;
    --blue-dark: #0066cc;
    --white: #ffffff;
    --muted: #6c757d;
    --success: #28a745;
    --danger: #dc3545;
    --radius: 12px;
    --transition: 0.3s ease;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
}

body.layout {
    background: #f9fbfd;
    color: #333;
    min-height: 100vh;
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 260px;
    height: 100vh;
    background: var(--blue-dark);
    color: var(--white);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    padding: 20px;
    gap: 12px;
    transition: transform var(--transition);
    z-index: 1000;
}

.brand a {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--white);
}

.brand-logo {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
}

.brand-name {
    font-weight: 700;
    font-size: 0.95rem;
    white-space: nowrap;
}

.menu {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 20px;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    color: var(--white);
    text-decoration: none;
    transition: background var(--transition), transform 0.2s;
}

.menu-item i {
    width: 20px;
    text-align: center;
}

.menu-item:hover,
.menu-item.active {
    background: var(--blue);
    transform: translateX(4px);
}

.sidebar-footer {
    margin-top: auto;
    font-size: 0.82rem;
    color: rgba(255, 255, 255, 0.7);
    text-align: center;
}

/* Main */
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
    justify-content: center;
    padding: 16px 28px;
    background: #fff;
    border-bottom: 1px solid #eaeaea;
    position: sticky;
    top: 0;
    z-index: 500;
}

.page-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--blue-dark);
    flex: 1;
    text-align: center;
}

.top-left {
    display: flex;
    align-items: center;
    gap: 12px;
    position: absolute;
    left: 20px;
}

.top-right {
    display: flex;
    align-items: center;
    gap: 12px;
    position: absolute;
    right: 20px;
}

.mobile-only {
    display: none;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-meta {
    text-align: right;
}

.user-meta strong {
    display: block;
    color: #222;
}

.role {
    color: var(--muted);
    font-size: 0.8rem;
}

/* Buttons */
.btn,
a.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    font-size: 0.9rem;
    font-weight: 500;
    border-radius: 8px;
    border: 1px solid transparent;
    background: var(--blue);
    color: #fff;
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
}

.btn:hover,
a.btn:hover {
    background: var(--blue-dark);
    transform: translateY(-2px);
}

.btn i,
a.btn i {
    font-size: 0.9rem;
}

.btn-ghost,
a.btn-ghost {
    background: transparent;
    border: 1px solid var(--blue);
    color: var(--blue);
}

.btn-ghost:hover,
a.btn-ghost:hover {
    background: var(--blue);
    color: var(--white);
}

/* New: Button danger style for table actions */
.btn-danger {
    background: var(--danger);
    border-color: var(--danger);
    color: var(--white);
}

.btn-danger:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

/* Alerts */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 0.9rem;
}

.alert.success {
    background: #d4edda;
    color: #155724;
}

.alert.danger {
    background: #f8d7da;
    color: #721c24;
}

/* Content full width */
.content {
    padding: 24px;
    width: 100%;
    margin: 20px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    flex: 1;
}

/* Footer */
.footer {
    margin-top: auto;
    padding: 12px 28px;
    display: flex;
    justify-content: space-between;
    color: var(--muted);
    border-top: 1px solid #eaeaea;
    background: #fff;
}

/* Loader */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    display: none;
}

.loader {
    border: 6px solid #f3f3f3;
    border-top: 6px solid var(--blue);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}

/* Confirmation Popup */
.confirm-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.confirm-box {
    background: #fff;
    padding: 25px 20px;
    border-radius: 12px;
    width: 90%;
    max-width: 350px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    animation: popIn 0.2s ease-out;
}

.confirm-box h3 {
    margin-bottom: 10px;
    font-size: 1.2rem;
    color: #333;
}

.confirm-box p {
    margin-bottom: 20px;
    color: #555;
}

.confirm-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.confirm-actions button {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
}

.confirm-actions .btn-confirm {
    background: #e74c3c;
    color: #fff;
}

.confirm-actions .btn-confirm:hover {
    background: #c0392b;
}

.confirm-actions .btn-cancel {
    background: #bdc3c7;
    color: #2c3e50;
}

.confirm-actions .btn-cancel:hover {
    background: #95a5a6;
}

@keyframes popIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* -------------------------------------- */
/* GLOBAL FORM STYLES (NEW) */
/* -------------------------------------- */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #444;
    font-size: 0.9rem;
}

.form-group input:not([type="checkbox"]),
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 1rem;
    color: #333;
    transition: border-color var(--transition), box-shadow var(--transition);
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 4px rgba(30, 144, 255, 0.2);
    outline: none;
}

.form-group textarea {
    resize: vertical;
}

.form-group input[type="file"] {
    border: none;
    padding: 8px 0;
}

.form-group ul {
    padding-left: 20px;
    margin-top: 5px;
}

/* -------------------------------------- */
/* GLOBAL CHECKBOX STYLES (NEW) */
/* -------------------------------------- */
.checkbox-group {
    border: 1px solid #ddd;
    padding: 12px;
    border-radius: var(--radius); /* Use global variable */
    max-height: 200px;
    overflow-y: auto;
    background-color: #fcfdff;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
}

.form-check {
    /* Use flexbox for vertical alignment */
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dashed #eee;
}

.form-check:last-child {
    margin-bottom: 0;
    border-bottom: none;
    padding-bottom: 0;
}

.form-check-input {
    width: 18px;
    height: 18px;
    margin-right: 12px;
    cursor: pointer;
    flex-shrink: 0;
    accent-color: var(--blue); /* Use the blue theme color */
}

.form-check-label {
    font-weight: 500;
    cursor: pointer;
    color: #333;
    font-size: 0.95rem;
    line-height: 1.3;
}


/* -------------------------------------- */
/* GLOBAL MODERN TABLE/PANEL STYLES */
/* -------------------------------------- */
.text-center {
    text-align: center;
}

/* Modern Panel/Card Container */
.modern-panel {
    background: linear-gradient(145deg, #ffffff, #f1f6ff);
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 24px;
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.panel-header h2 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--blue-dark);
    margin: 0;
}

/* Table Card Body */
.panel-body {
    padding: 24px; /* Default padding for content, including forms */
}

/* Specific override for tables that should span full width */
.panel-body.table-responsive {
    padding: 0 24px 24px 24px;
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
    margin-top: 12px;
}

.modern-table th {
    text-align: left;
    padding: 12px 16px;
    font-weight: 600;
    color: var(--blue-dark);
    background: transparent;
}

/* The table body rows act as cards */
.modern-table td {
    padding: 12px 16px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
    vertical-align: middle;
}

.modern-table tr:hover td {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.muted {
    color: var(--muted);
    font-style: italic;
}




/* --- UTILITY CLASSES --- */

/**
 * FIX: This class was missing. It is mandatory for the JavaScript
 * to hide the target fields correctly.
 */
.d-none {
    display: none !important; 
}

/* Responsive */
@media(max-width:900px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .main {
        margin-left: 0;
    }

    .mobile-only {
        display: inline-flex;
    }
}

/* Responsive Table for smaller screens */
@media(max-width:768px) {
    .modern-table {
        border-spacing: 0;
        margin-top: 0;
    }

    .modern-table thead {
        display: none;
    }

    .modern-table tr {
        display: block;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        overflow: hidden;
    }

    .modern-table tr:hover td {
        transform: none;
        box-shadow: none;
    }

    .modern-table td {
        display: flex;
        justify-content: space-between;
        padding: 12px 16px;
        background: #fff;
        box-shadow: none;
        border-radius: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-table tr td:last-child {
        border-bottom: none;
    }

    /* Ensures action buttons are visible and aligned */
    .modern-table td[data-label="Actions"] {
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 8px;
    }

    .modern-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--blue-dark);
    }
}

   </style>

    @stack('styles')
</head>

<body class="layout">

    <!-- Loader -->
    <div id="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ARM Logo" class="brand-logo"
                    onerror="this.style.display='none'" />
                <span class="brand-name">ARM ENGLISH ACADEMY</span>
            </a>
        </div>

        <nav class="menu">
            <a href="/" class="menu-item ">
                <i class="fa fa-home"></i><span>Home Page</span>
            </a>

            <a href="{{ route('admin.dashboard') }}"
                class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}"
                class="menu-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                <i class="fa fa-user-graduate"></i><span>Students</span>
            </a>
            <a href="{{ route('admin.courses') }}"
                class="menu-item {{ request()->routeIs('admin.courses') ? 'active' : '' }}">
                <i class="fa fa-book"></i><span>Courses</span>
            </a>
            <a href="{{ route('admin.lectures.index') }}"
                class="menu-item {{ request()->routeIs('admin.lectures.*') ? 'active' : '' }}">
                <i class="fa fa-video"></i><span>Lectures</span>
            </a>

            <a href="{{ route('admin.notices.index') }}"
                class="menu-item {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                <i class="fa fa-bell"></i><span>Notice</span>
            </a>
            <a href="#" class="menu-item"><i class="fa fa-calendar"></i><span>Events</span></a>
            <a href="#" class="menu-item"><i class="fa fa-cog"></i><span>Settings</span></a>
        </nav>

        <div class="sidebar-footer">
            <small>© {{ date('Y') }} ARM</small>
        </div>
    </aside>

    <!-- Main -->
    <div class="main">
        <header class="topbar">
            <div class="top-left">
                <button id="mobileMenuBtn" class="btn-icon mobile-only"><i class="fa fa-bars"></i></button>
            </div>
            <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            <div class="top-right">
                <div class="user-info">
                    <div class="user-meta">
                        <strong>{{ Auth::user()->name ?? 'Admin User' }}</strong>
                        <small class="role">{{ Auth::user()->role ?? 'Administrator' }}</small>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-ghost" type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>

        <footer class="footer">
            <div>ARM ENGLISH ACADEMY · Admin Panel</div>
        </footer>
    </div>

    <!-- JS -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const loader = document.getElementById('loader');

        // Mobile toggle
        mobileMenuBtn.addEventListener('click', () => sidebar.classList.toggle('open'));

        // Click outside to close sidebar
        document.addEventListener('click', e => {
            if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target) && window.innerWidth < 900) {
                sidebar.classList.remove('open');
            }
        });

        // Show loader for all forms EXCEPT delete forms
        document.querySelectorAll('form:not(.deleteForm)').forEach(form => {
            form.addEventListener('submit', () => {
                loader.style.display = 'flex';
            });
        });

        // Global Delete Confirmation
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.deleteForm').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // stop default submit

                    // Remove existing modal if any
                    const existingModal = document.querySelector('.confirm-overlay');
                    if (existingModal) existingModal.remove();

                    // Create modal
                    const modal = document.createElement('div');
                    modal.classList.add('confirm-overlay');
                    modal.innerHTML = `
                        <div class="confirm-box">
                            <h3>Confirm Delete</h3>
                            <p>Are you sure you want to delete this item?</p>
                            <div class="confirm-actions">
                                <button type="button" class="btn-confirm">Yes, Delete</button>
                                <button type="button" class="btn-cancel">Cancel</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);

                    // Cancel button
                    modal.querySelector('.btn-cancel').addEventListener('click', () => modal.remove());

                    // Confirm button
                    modal.querySelector('.btn-confirm').addEventListener('click', () => {
                        modal.remove();
                        loader.style.display = 'flex'; // show loader
                        form.submit(); // submit form
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
