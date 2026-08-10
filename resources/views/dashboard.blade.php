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
        <span class="chip"><i data-lucide="infinity" aria-hidden="true"></i>Unlimited storage</span>
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
        <div class="storage-detail unlimited-storage-overview">
            <h3>Storage Overview</h3>

            <div class="unlimited-storage-overview-icon">
                <i data-lucide="infinity" aria-hidden="true"></i>
            </div>

            <strong class="unlimited-storage-overview-title">Unlimited Storage</strong>

            <div class="unlimited-storage-overview-used">{{ $storageUsed }} MB</div>

            <span class="unlimited-storage-overview-caption">Currently Used</span>

            <div class="unlimited-storage-powered">
                <i data-lucide="send" aria-hidden="true"></i>
                <span>Powered by Telegram</span>
            </div>
        </div>
    </div>

</div>

@endsection

