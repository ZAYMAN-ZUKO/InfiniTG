@extends('layouts.app')

@section('title', 'Trash')

@section('content')

<div class="pagehead">
    <div>
        <h1>Trash</h1>
        <p>Deleted files are kept here for a while before permanent removal.</p>
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
        <h3><i data-lucide="trash-2" aria-hidden="true"></i> Deleted Files</h3>
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
                    <span class="file-cell file-type">{{ $file->deleted_at->format('d M Y') }}</span>
                    <div class="file-actions">
                        <form action="{{ route('restore', $file->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-soft btn-sm" type="submit" title="Restore">
                                <i data-lucide="rotate-ccw" aria-hidden="true"></i>Restore
                            </button>
                        </form>
                        <form action="{{ route('forceDelete', $file->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit" title="Delete forever" onclick="return confirm('This action cannot be undone. Delete this file permanently?')">
                                <i data-lucide="trash" aria-hidden="true"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <span class="empty-icon"><i data-lucide="trash-2" aria-hidden="true"></i></span>
            <h3>Trash is empty</h3>
            <p>Deleted files will appear here before being permanently removed.</p>
            <a class="btn btn-primary" href="{{ route('files.index') }}">
                <i data-lucide="folder" aria-hidden="true"></i>Go to My Files
            </a>
        </div>
    @endif
</div>

@endsection
