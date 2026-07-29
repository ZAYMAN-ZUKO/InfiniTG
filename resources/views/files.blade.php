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

@endsection