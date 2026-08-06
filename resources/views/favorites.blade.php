@extends('layouts.app')

@section('title', 'Favorites')

@section('content')

<div class="pagehead">
    <div>
        <h1>Favorites</h1>
        <p>Files you've starred for quick access.</p>
    </div>
    <div class="actions">
        <a class="btn btn-ghost" href="{{ route('files.index') }}">
            <i data-lucide="arrow-left" aria-hidden="true"></i>Back to files
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" data-toast="{{ session('success') }}">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="card">
    <div class="panel-head">
        <h3><i data-lucide="star" aria-hidden="true"></i> Favorite Files</h3>
        <span class="badge">{{ $files->count() }} file(s)</span>
    </div>

    @if($files->count())
        <div class="file-list">
            @foreach($files as $file)
                <div class="file-row">
                    @include('partials.file-icon', ['file' => $file])
                    <div class="file-info">
                        <b>{{ $file->original_name }}</b>
                        <span>{{ $file->mime_type ?? 'Unknown type' }}</span>
                    </div>
                    <span class="file-cell file-size">{{ number_format($file->file_size / 1024, 1) }} KB</span>
                    <span class="file-cell file-type">{{ $file->created_at->format('d M Y') }}</span>
                    <div class="file-actions">
                        <a class="btn btn-ghost btn-sm btn-icon" href="{{ route('download', $file->id) }}" title="Download">
                            <i data-lucide="download" aria-hidden="true"></i>
                        </a>
                        <form action="{{ route('favorite.toggle', $file->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-ghost btn-sm btn-icon" type="submit" title="Unfavorite">
                                <i data-lucide="star" aria-hidden="true" style="fill:var(--warn);color:var(--warn)"></i>
                            </button>
                        </form>
                        <form action="{{ route('delete', $file->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Delete" onclick="return confirm('Move this file to Trash?')">
                                <i data-lucide="trash-2" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <span class="empty-icon"><i data-lucide="star" aria-hidden="true"></i></span>
            <h3>No favorite files</h3>
            <p>Star files from My Files to pin them here.</p>
            <a class="btn btn-primary" href="{{ route('files.index') }}">
                <i data-lucide="folder" aria-hidden="true"></i>Browse files
            </a>
        </div>
    @endif
</div>

@endsection
