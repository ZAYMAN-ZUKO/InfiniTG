<aside class="sidebar" aria-label="Primary">

    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <span class="sidebar-brand-mark"><i data-lucide="infinity" aria-hidden="true"></i></span>
        <span class="sidebar-brand-name">InfiniTG<small>Cloud Storage</small></span>
    </a>

    <div class="sidebar-actions">
        <button class="btn btn-primary" type="button" data-open-modal="upload">
            <i data-lucide="upload" aria-hidden="true"></i>Upload
        </button>
        <button class="btn btn-soft" type="button" data-open-modal="folder">
            <i data-lucide="folder-plus" aria-hidden="true"></i>New
        </button>
    </div>

    <span class="sidebar-nav-label">Library</span>
    <nav class="sidebar-nav" aria-label="Sections">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i data-lucide="layout-dashboard" aria-hidden="true"></i>Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('files.*') ? 'active' : '' }}" href="{{ route('files.index') }}">
            <i data-lucide="folder" aria-hidden="true"></i>My Files
        </a>
        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">
            <i data-lucide="images" aria-hidden="true"></i>Gallery
        </a>
        <a class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">
            <i data-lucide="star" aria-hidden="true"></i>Favorites
        </a>
        <a class="nav-link {{ request()->routeIs('recent') ? 'active' : '' }}" href="{{ route('recent') }}">
            <i data-lucide="clock" aria-hidden="true"></i>Recent
        </a>
        <a class="nav-link {{ request()->routeIs('trash') ? 'active' : '' }}" href="{{ route('trash') }}">
            <i data-lucide="trash-2" aria-hidden="true"></i>Trash
        </a>
    </nav>

    <span class="sidebar-nav-label">Account</span>
    <nav class="sidebar-nav" aria-label="Account">
        <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">
            <i data-lucide="settings" aria-hidden="true"></i>Settings
        </a>
    </nav>

    <div class="sidebar-spacer"></div>

    <div class="storage-meter">
        <div class="storage-meter-head">
            <i data-lucide="hard-drive" aria-hidden="true"></i>Storage
        </div>
        @if(isset($storageUsed) && isset($storageMax))
            <div class="storage-meter-bar">
                <div class="storage-meter-fill" style="width:{{ $storagePercent ?? 0 }}%"></div>
            </div>
            <div class="storage-meter-meta">
                <b>{{ $storageUsed }} MB</b>
                <span>of {{ $storageMax }} MB</span>
            </div>
        @else
            <div class="storage-meter-bar">
                <div class="storage-meter-fill" style="width:0%"></div>
            </div>
            <div class="storage-meter-meta">
                <b>0 MB</b>
                <span>of 2048 MB</span>
            </div>
        @endif
    </div>

</aside>
