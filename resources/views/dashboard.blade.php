@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@if(session('success'))
    <div class="alert alert-success" data-toast="{{ session('success') }}">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="hello">
    <span class="hello-icon"><i data-lucide="cloud" aria-hidden="true"></i></span>
    <div>
        <h2>Welcome back, {{ Auth::user()->name }}</h2>
        <p>Here's what's happening with your cloud today.</p>
    </div>
    <div class="hello-meta">
        <span class="chip"><i data-lucide="zap" aria-hidden="true"></i>Telegram powered</span>
        <span class="chip"><i data-lucide="shield-check" aria-hidden="true"></i>2 GB free plan</span>
    </div>
</div>

<div class="stats">
    <div class="stat">
        <span class="stat-icon ic-indigo"><i data-lucide="folder" aria-hidden="true"></i></span>
        <div>
            <b>{{ $totalFiles }}</b>
            <span>Total Files</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-violet"><i data-lucide="hard-drive" aria-hidden="true"></i></span>
        <div>
            <b>{{ $storageUsed }} MB</b>
            <span>Storage Used</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-amber"><i data-lucide="star" aria-hidden="true"></i></span>
        <div>
            <b>{{ $favoriteCount }}</b>
            <span>Favorites</span>
        </div>
    </div>
    <div class="stat">
        <span class="stat-icon ic-red"><i data-lucide="trash-2" aria-hidden="true"></i></span>
        <div>
            <b>{{ $trashCount }}</b>
            <span>In Trash</span>
        </div>
    </div>
</div>

<div class="dash-grid">

    <div class="card">
        <div class="card-head">
            <h3>Recent Files</h3>
            <a class="link" href="{{ route('recent') }}">
                View all <i data-lucide="arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        @php
        $recentFiles = $recentFiles ?? collect();
        @endphp
        <div class="recent">
        @forelse($recentFiles as $file)
            <div class="recent-row">
                @include('partials.file-icon', ['file' => $file])
                <div class="recent-meta">
                    <b>{{ $file->original_name }}</b>
                    <span>{{ $file->mime_type ?? 'Unknown type' }}</span>
                </div>
                <span class="recent-time">{{ $file->created_at->diffForHumans() }}</span>
                <div class="file-actions">
                    <a class="btn btn-ghost btn-sm btn-icon" href="{{ route('download', $file->id) }}" title="Download">
                        <i data-lucide="download" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty">
                <span class="empty-icon"><i data-lucide="file" aria-hidden="true"></i></span>
                <h3>No files yet</h3>
                <p>Upload your first file to get started.</p>
                <button class="btn btn-primary" type="button" data-open-modal="upload">
                    <i data-lucide="upload" aria-hidden="true"></i>Upload a file
                </button>
            </div>
        @endforelse
        </div>
    </div>

    <div class="card">
        <div class="storage-detail">
            <h3>Storage Overview</h3>
            <p>{{ $storageUsed }} MB used of {{ $maxStorage }} MB</p>

            <div class="ring">
                <svg viewBox="0 0 120 120" aria-hidden="true">
                    <circle class="ring-bg" cx="60" cy="60" r="50"></circle>
                    <circle class="ring-fg" cx="60" cy="60" r="50" stroke-dashoffset="{{ 314.16 - (314.16 * $storagePercentage / 100) }}"></circle>
                </svg>
                <div class="ring-center">
                    <b>{{ round($storagePercentage) }}%</b>
                    <span>Used</span>
                </div>
            </div>

            <div class="breakdown">
                <div class="break-row">
                    <span class="break-dot" style="background:var(--brand)"></span>
                    Storage used
                    <b>{{ $storageUsed }} MB</b>
                </div>
                <div class="break-row">
                    <span class="break-dot" style="background:var(--surface-3)"></span>
                    Free space
                    <b>{{ max($maxStorage - $storageUsed, 0) }} MB</b>
                </div>
            </div>

            <a class="btn btn-primary btn-block" href="{{ route('settings') }}">
                <i data-lucide="rocket" aria-hidden="true"></i>Upgrade Storage
            </a>
        </div>
    </div>

</div>

@endsection
