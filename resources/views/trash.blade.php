@extends('layouts.app')

@section('title', 'Trash')

@section('content')

<h1 style="margin-bottom:25px;">Trash</h1>

<div class="panel">

    @if(session('success'))
        <p style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </p>
    @endif

    <h2 style="margin-bottom:20px;">Deleted Files</h2>

    <table>

        <thead>
            <tr>
                <th>File Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Deleted On</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($files as $file)

            <tr>

                <td>{{ $file->original_name }}</td>

                <td>{{ $file->mime_type }}</td>

                <td>{{ number_format($file->file_size / 1024, 2) }} KB</td>

                <td>{{ $file->deleted_at->format('d M Y') }}</td>

                <td>

                    {{-- Restore --}}
                    <form action="{{ route('restore', $file->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn">
                            ♻ Restore
                        </button>

                    </form>

                    {{-- Delete Forever --}}
                    <form action="{{ route('forceDelete', $file->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn"
                            onclick="return confirm('This action cannot be undone. Delete this file permanently?')">

                            ❌ Delete Forever

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;">
                    Trash is empty.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection