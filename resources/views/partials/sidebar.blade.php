<div class="sidebar">

    <div class="logo">
        ∞ InfiniTG
    </div>

    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
       href="{{ route('dashboard') }}">
        Dashboard
    </a>

    <a class="{{ request()->routeIs('files') ? 'active' : '' }}"
       href="{{ route('files') }}">
        My Files
    </a>

    <a class="{{ request()->routeIs('gallery') ? 'active' : '' }}"
       href="{{ route('gallery') }}">
        Gallery
    </a>

    <a class="{{ request()->routeIs('favorites') ? 'active' : '' }}"
       href="{{ route('favorites') }}">
        Favorites
    </a>

    <a class="{{ request()->routeIs('recent') ? 'active' : '' }}"
       href="{{ route('recent') }}">
        Recent
    </a>

    <a class="{{ request()->routeIs('trash') ? 'active' : '' }}"
       href="{{ route('trash') }}">
        Trash
    </a>

    <a class="{{ request()->routeIs('settings') ? 'active' : '' }}"
       href="{{ route('settings') }}">
        Settings
    </a>

</div>