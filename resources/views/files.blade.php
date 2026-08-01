@extends('layouts.app')

@section('title', 'My Files')

@section('content')

<h1 style="margin-bottom:25px;">My Files</h1>

{{-- Upload Panel --}}
<div class="panel">

    @if(session('success'))
        <p style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </p>
    @endif

    @if($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <input
            type="file"
            name="file"
            required
            style="margin-bottom:15px;">

        <button type="submit" class="btn">
            📤 Upload File
        </button>

    </form>

</div>

{{-- Files List --}}
<div class="panel">

    <h2 style="margin-bottom:20px;">Uploaded Files</h2>

    <table>

        <thead>
            <tr>
                <th>File Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Uploaded</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($files as $file)

            <tr>

                <td>{{ $file->original_name }}</td>

                <td>{{ $file->mime_type }}</td>

                <td>{{ number_format($file->file_size / 1024, 2) }} KB</td>

                <td>{{ $file->created_at->format('d M Y') }}</td>

                <td>

                    {{-- Download --}}
                    <a href="{{ route('download', $file->id) }}" class="btn">
                        ⬇ Download
                    </a>

                    {{-- Favorite --}}
                    <form action="{{ route('favorite.toggle', $file->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn">
                            @if($file->is_favorite)
                                ⭐ Unfavorite
                            @else
                                ☆ Favorite
                            @endif
                        </button>

                    </form>

                    <br><br>

                    {{-- Rename --}}
                    <form action="{{ route('rename', $file->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('PUT')

                        <input
                            type="text"
                            name="original_name"
                            value="{{ $file->original_name }}"
                            required
                            style="padding:6px; width:180px;">

                        <button type="submit" class="btn">
                            ✏ Rename
                        </button>

                    </form>

                    {{-- Delete --}}
                    <form action="{{ route('delete', $file->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn"
                            onclick="return confirm('Are you sure you want to move this file to Trash?')">

                            🗑 Delete

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;">
                    No files uploaded yet.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

{{-- Folder Section --}}
<div class="panel" style="margin-bottom:25px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">

        <h2>Folders</h2>

        <form
            action="{{ route('folders.store') }}"
            method="POST"
            style="display:flex; gap:10px;"
        >
            @csrf

            <input
                type="text"
                name="name"
                placeholder="Folder name"
                required
            >

            <button
                class="btn"
                type="submit"
            >
                📁 New Folder
            </button>

        </form>

    </div>

    @if($folders->count())

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
            gap:15px;
        ">

            @foreach($folders as $folder)

                <div style="
                    border:1px solid #ddd;
                    border-radius:10px;
                    padding:18px;
                    background:#fff;
                ">

                    <div style="
                        font-size:18px;
                        font-weight:bold;
                    ">
                        <a
    href="{{ route('folders.show', $folder) }}"
    style="
        text-decoration:none;
        color:inherit;
        display:block;
    "
>
    📁 {{ $folder->name }}
</a>
                    </div>
<div style="margin-top:15px;">

    <form
        action="{{ route('folders.update', $folder) }}"
        method="POST"
        style="margin-bottom:8px;"
    >
        @csrf
        @method('PUT')

        <input
            type="text"
            name="name"
            value="{{ $folder->name }}"
            style="width:100%; margin-bottom:8px;"
        >

        <button
            class="btn"
            style="width:100%;"
        >
            ✏ Rename
        </button>

    </form>

    <form
        action="{{ route('folders.destroy', $folder) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')

        <button
            class="btn"
            style="width:100%; background:#dc3545;"
            onclick="return confirm('Delete this folder?')"
        >
            🗑 Delete
        </button>

    </form>

</div>
                    <div style="
                        margin-top:10px;
                        color:#888;
                        font-size:13px;
                    ">
                        Created:
                        {{ $folder->created_at->format('d M Y') }}
                    </div>

                </div>

            @endforeach

        </div>

    @else

        <p>No folders yet.</p>

    @endif

</div>

@endsection