@extends('layouts.app')

@section('title', 'Recent')

@section('content')

<div class="pagehead">
    <div>
        <h1>Recent Files</h1>
        <p>Your latest uploads, right at your fingertips.</p>
    </div>
    <div class="actions">
        <button class="btn btn-primary" type="button" data-open-modal="upload">
            <i data-lucide="upload" aria-hidden="true"></i>Upload
        </button>
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
        <h3><i data-lucide="clock" aria-hidden="true"></i> Latest Uploads</h3>
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
                    <span class="file-cell file-type">{{ $file->created_at->format('d M Y h:i A') }}</span>
                    <div class="file-actions">
                        <a class="btn btn-ghost btn-sm btn-icon" href="{{ route('download', $file->id) }}" title="Download">
                            <i data-lucide="download" aria-hidden="true"></i>
                        </a>
                        <form action="{{ route('favorite.toggle', $file->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-ghost btn-sm btn-icon" type="submit" title="Favorite">
                                <i data-lucide="star" aria-hidden="true" style="{{ $file->is_favorite ? 'fill:var(--warn);color:var(--warn)' : '' }}"></i>
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
            <span class="empty-icon"><i data-lucide="clock" aria-hidden="true"></i></span>
            <h3>No recent files</h3>
            <p>Upload a file and it will show up here.</p>
            <button class="btn btn-primary" type="button" data-open-modal="upload">
                <i data-lucide="upload" aria-hidden="true"></i>Upload a file
            </button>
        </div>
    @endif
</div>

@endsection
