<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'InfiniTG') | InfiniTG</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
</head>
<body>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <defs>
        <linearGradient id="ig-grad" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#6366f1"/>
            <stop offset="100%" stop-color="#a78bfa"/>
        </linearGradient>
    </defs>
</svg>

<div class="app">

    @include('partials.sidebar')

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main">

        @include('partials.topbar')

        <main class="content">
            @yield('content')
        </main>

        @include('partials.footer')

    </div>

</div>

@include('partials.modals')

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script src="/js/app.js"></script>
<script>
(function () {
    if (window.lucide) { lucide.createIcons(); }

    var menuBtn = document.getElementById('menuBtn');
    var backdrop = document.getElementById('sidebarBackdrop');
    if (menuBtn) {
        menuBtn.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-open');
        });
    }
    if (backdrop) {
        backdrop.addEventListener('click', function () {
            document.body.classList.remove('sidebar-open');
        });
    }

    document.querySelectorAll('[data-open-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modal = document.getElementById('modal-' + btn.dataset.openModal);
            if (modal) { modal.classList.add('open'); }
        });
    });
    document.querySelectorAll('[data-close-modal]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var modal = btn.closest('.modal-wrap');
            if (modal) { modal.classList.remove('open'); }
        });
    });
    document.querySelectorAll('.modal-backdrop').forEach(function (bg) {
        bg.addEventListener('click', function () {
            bg.closest('.modal-wrap').classList.remove('open');
        });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-wrap.open').forEach(function (m) {
                m.classList.remove('open');
            });
        }
    });

    document.querySelectorAll('[data-rename-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var form = document.getElementById(btn.dataset.renameToggle);
            if (form) {
                form.classList.toggle('open');
                var input = form.querySelector('input');
                if (form.classList.contains('open') && input) { input.focus(); }
            }
        });
    });



})();
</script>

@stack('scripts')

</body>
</html>


