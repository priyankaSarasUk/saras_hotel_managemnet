<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hotel Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .content-wrapper {
            margin-left: 260px; /* same width as sidebar */
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            border-right: 1px solid rgba(255,255,255,0.1);
            z-index: 1050;
            background-color: #212529;
            transition: transform 0.3s ease;
        }

        /* Desktop always visible */
        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0);
            }
        }

        /* Mobile hidden by default */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 1040;
        }
        .overlay.active {
            display: block;
        }
    </style>

    {{-- Page-specific CSS will be injected here --}}
    @stack('css')
</head>
<body>

<!-- Top navbar (mobile only) -->
<nav class="navbar navbar-dark bg-dark d-md-none px-3">
    <button id="sidebarToggle" class="btn btn-outline-light">
        <i data-feather="menu"></i>
    </button>
    <span class="navbar-text text-white ms-2">Hotel Admin</span>
</nav>

<div class="d-flex">
    {{-- Sidebar --}}
    @include('layout.sidebar')

    {{-- Overlay --}}
    <div id="overlay" class="overlay"></div>

    {{-- Main content --}}
    <div class="flex-grow-1 content-wrapper">
        <div class="p-4">
            @yield('content')
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Feather Icons + Sidebar Logic -->
<script>
    feather.replace();

    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleBtns = document.querySelectorAll("#sidebarToggle, #sidebarToggleInside");
        const overlay = document.getElementById("overlay");
        const links = document.querySelectorAll(".sidebar a");

        function toggleSidebar() {
            sidebar.classList.toggle("show");
            overlay.classList.toggle("active");
        }

        toggleBtns.forEach(btn => {
            if (btn) btn.addEventListener("click", toggleSidebar);
        });

        if (overlay) overlay.addEventListener("click", toggleSidebar);

        // Auto-close sidebar when clicking a link on mobile
        links.forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove("show");
                    overlay.classList.remove("active");
                }
            });
        });
    });
</script>

{{-- Page-specific JS can be injected here if needed --}}
@stack('scripts')

</body>
</html>
