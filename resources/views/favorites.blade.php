@extends('layouts.app')

@section('title', 'Favorites')

@section('content')

<h1 style="margin-bottom:25px;">Favorite Files</h1>

<div class="panel">

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

                    <a href="{{ route('download', $file->id) }}" class="btn">
                        ⬇ Download
                    </a>

                    <form action="{{ route('favorite.toggle', $file->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn">
                            ⭐ Unfavorite
                        </button>
                    </form>

                    <form action="{{ route('delete', $file->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn"
                                onclick="return confirm('Move this file to Trash?')">
                            🗑 Delete
                        </button>
                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;">
                    No favorite files found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection