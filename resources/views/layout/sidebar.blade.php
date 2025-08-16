<div id="sidebar" class="sidebar d-flex flex-column bg-dark text-white p-3 shadow">
    <!-- Top section with username + close button (mobile only) -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="fw-bold">{{ Auth::user()->name }}</div>
        <button id="sidebarToggleInside" class="btn btn-outline-light d-md-none">
            <i data-feather="menu"></i>
        </button>
    </div>

    <ul class="nav flex-column nav-pills">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
               class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-link {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i data-feather="home" class="me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('bookings.index') }}"
               class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-link {{ request()->routeIs('bookings.index') ? 'active bg-primary' : '' }}">
                <i data-feather="calendar" class="me-2"></i> Bookings
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('rooms.index') }}"
               class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-link {{ request()->routeIs('rooms.index') ? 'active bg-primary' : '' }}">
                <i data-feather="layers" class="me-2"></i> Rooms
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('customers.index') }}"
               class="nav-link text-white d-flex align-items-center px-3 py-2 rounded hover-link {{ request()->routeIs('customers.index') ? 'active bg-primary' : '' }}">
                <i data-feather="users" class="me-2"></i> Customers
            </a>
        </li>
        <li class="nav-item mt-auto">
            <a href="{{ route('logout') }}"
               class="nav-link text-danger d-flex align-items-center px-3 py-2 rounded hover-logout">
                <i data-feather="log-out" class="me-2"></i> Logout
            </a>
        </li>
    </ul>
</div>

<style>
    .hover-link:hover {
        background-color: rgba(255,255,255,0.1);
        transition: 0.3s;
    }
    .hover-logout:hover {
        background-color: rgba(220,53,69,0.1);
        transition: 0.3s;
    }
    .nav-link.active {
        font-weight: bold;
    }
</style>
