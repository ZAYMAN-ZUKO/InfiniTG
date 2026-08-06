@extends('layouts.app')

@section('title', 'My Files')

@section('content')

<div class="pagehead">
    <div>
        <h1>My Files</h1>
        <p>Store, organize and access your files.</p>
    </div>
    <div class="actions">
        <button class="btn btn-primary" type="button" data-open-modal="upload">
            <i data-lucide="upload" aria-hidden="true"></i>Upload
        </button>
        <button class="btn btn-soft" type="button" data-open-modal="folder">
            <i data-lucide="folder-plus" aria-hidden="true"></i>New Folder
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" data-toast="{{ session('success') }}">
        <i data-lucide="check-circle" aria-hidden="true"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <i data-lucide="alert-circle" aria-hidden="true"></i>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($search))
    <div class="alert alert-info">
        <i data-lucide="search" aria-hidden="true"></i>
        <span>Search results for &ldquo;{{ $search }}&rdquo; &mdash; {{ $files->count() }} file(s) found.</span>
    </div>
@endif

{{-- Folders --}}
<div class="card" style="margin-bottom:20px">
    <div class="panel-head">
        <h3><i data-lucide="folder" aria-hidden="true"></i> Folders</h3>
        <button class="btn btn-ghost btn-sm" type="button" data-open-modal="folder">
            <i data-lucide="plus" aria-hidden="true"></i>New Folder
        </button>
    </div>

    @if($folders->count())
        <div class="folder-grid">
            @foreach($folders as $folder)
                <div class="folder-card">
                    <span class="folder-icon"><i data-lucide="folder" aria-hidden="true"></i></span>
                    <h4><a href="{{ route('folders.show', $folder) }}">{{ $folder->name }}</a></h4>
                    <p>Created {{ $folder->created_at->format('d M Y') }}</p>

                    <div class="folder-rename">
                        <form action="{{ route('folders.update', $folder) }}" method="POST" class="rename-form" id="folder-rename-{{ $folder->id }}">
                            @csrf
                            @method('PUT')
                            <input class="input" type="text" name="name" value="{{ $folder->name }}" required maxlength="255">
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-primary btn-sm" type="submit">Save</button>
                            </div>
                        </form>
                        <div style="display:flex;gap:6px">
                            <button class="btn btn-ghost btn-sm" type="button" data-rename-toggle="folder-rename-{{ $folder->id }}">
                                <i data-lucide="pencil" aria-hidden="true"></i>Rename
                            </button>
                            <form action="{{ route('folders.destroy', $folder) }}" method="POST" style="flex:1">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-block" type="submit" onclick="return confirm('Delete this folder?')">
                                    <i data-lucide="trash-2" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <span class="empty-icon"><i data-lucide="folder-plus" aria-hidden="true"></i></span>
            <h3>No folders yet</h3>
            <p>Create folders to organize your files.</p>
        </div>
    @endif
</div>

{{-- Files --}}
<div class="card">
    <div class="panel-head">
        <h3><i data-lucide="file" aria-hidden="true"></i> Uploaded Files</h3>
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
                            <button class="btn btn-ghost btn-sm btn-icon {{ $file->is_favorite ? 'is-fav' : '' }}" type="submit" title="{{ $file->is_favorite ? 'Unfavorite' : 'Favorite' }}">
                                <i data-lucide="{{ $file->is_favorite ? 'star' : 'star' }}" aria-hidden="true" style="{{ $file->is_favorite ? 'fill:var(--warn);color:var(--warn)' : '' }}"></i>
                            </button>
                        </form>
                        <button class="btn btn-ghost btn-sm btn-icon" type="button" data-rename-toggle="file-rename-{{ $file->id }}" title="Rename">
                            <i data-lucide="pencil" aria-hidden="true"></i>
                        </button>
                        <form action="{{ route('delete', $file->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Delete" onclick="return confirm('Move this file to Trash?')">
                                <i data-lucide="trash-2" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <form class="rename-form" id="file-rename-{{ $file->id }}" action="{{ route('rename', $file->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input class="input" type="text" name="original_name" value="{{ $file->original_name }}" required maxlength="255">
                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                    <button class="btn btn-ghost btn-sm" type="button" data-rename-toggle="file-rename-{{ $file->id }}">Cancel</button>
                </form>
            @endforeach
        </div>
    @else
        <div class="empty">
            <span class="empty-icon"><i data-lucide="upload-cloud" aria-hidden="true"></i></span>
            <h3>No files uploaded yet</h3>
            <p>Drop your first file and it will be stored on Telegram's cloud.</p>
            <button class="btn btn-primary" type="button" data-open-modal="upload">
                <i data-lucide="upload" aria-hidden="true"></i>Upload a file
            </button>
        </div>
    @endif
</div>

@endsection
