<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Belajar.ID' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="wrapper">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="logo">BELAJAR.ID</span>
            <button id="toggleBtn" type="button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <ul class="menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span class="menu-text">Beranda</span>
                </a>
            </li>

            <li class="menu-item-has-submenu">
                <button type="button" class="submenu-toggle {{ request()->is('materi*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    <span class="menu-text">Materi</span>
                    <i class="fa-solid fa-chevron-down arrow-icon {{ request()->is('materi*') ? 'rotate' : '' }}"></i>
                </button>

                <div class="submenu {{ request()->is('materi*') ? 'open' : '' }}">
                    <a href="{{ route('materi1') }}" class="{{ request()->routeIs('materi1*') ? 'active' : '' }}">Materi 1</a>
                    <a href="{{ route('materi2') }}" class="{{ request()->routeIs('materi2*') ? 'active' : '' }}">Materi 2</a>
                    <a href="{{ route('materi3') }}" class="{{ request()->routeIs('materi3*') ? 'active' : '' }}">Materi 3</a>
                </div>
            </li>

            <li>
                <a href="{{ route('evaluasi') }}" class="{{ request()->routeIs('evaluasi') ? 'active' : '' }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span class="menu-text">Evaluasi</span>
                </a>
            </li>
        </ul>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>

</body>
</html>