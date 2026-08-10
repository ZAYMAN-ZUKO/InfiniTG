@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<div class="pagehead">
    <div>
        <h1>Gallery</h1>
        <p>All your images in one place.</p>
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

@if($files->count())
    <div class="gallery">
        @foreach($files as $file)
            <div class="photo">
                @php
                    $previewSrc = $file->storage_driver === 'telegram'
                        ? route('preview', $file->id)
                        : asset('storage/' . $file->file_path);
                @endphp
                <img class="photo-img skeleton" src="{{ $previewSrc }}" alt="{{ $file->original_name }}" loading="lazy"
                     data-lightbox
                     data-full="{{ $previewSrc }}"
                     data-download="{{ route('download', $file->id) }}"
                     data-fav-url="{{ route('favorite.toggle', $file->id) }}"
                     data-fav="{{ $file->is_favorite ? '1' : '0' }}"
                     data-meta="{{ number_format($file->file_size / 1024, 1) }} KB &middot; {{ $file->created_at->format('d M Y') }}">

                <div class="photo-body">
                    <b>{{ $file->original_name }}</b>
                    <span>{{ number_format($file->file_size / 1024, 1) }} KB &middot; {{ $file->created_at->format('d M Y') }}</span>

                    <div class="photo-actions">
                        <a class="btn btn-ghost btn-sm" href="{{ route('download', $file->id) }}">
                            <i data-lucide="download" aria-hidden="true"></i>Download
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
                            <button class="btn btn-danger btn-sm btn-icon" type="submit" title="Delete" onclick="return confirm('Move this image to Trash?')">
                                <i data-lucide="trash-2" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card">
        <div class="empty">
            <span class="empty-icon"><i data-lucide="images" aria-hidden="true"></i></span>
            <h3>No images found</h3>
            <p>Upload JPG, PNG, WEBP or GIF images to see them here.</p>
            <button class="btn btn-primary" type="button" data-open-modal="upload">
                <i data-lucide="upload" aria-hidden="true"></i>Upload an image
            </button>
        </div>
    </div>
@endif

@include('partials.lightbox')

@endsection

