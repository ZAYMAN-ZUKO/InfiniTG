@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<h1 style="margin-bottom:25px;">Gallery</h1>

<div class="panel">

    <h2 style="margin-bottom:20px;">Image Gallery</h2>

    @if($files->count())

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(220px,1fr));
            gap:20px;
        ">

            @foreach($files as $file)

                <div style="
                    border:1px solid #ddd;
                    border-radius:10px;
                    overflow:hidden;
                    background:#fff;
                ">

                    <img
                        src="{{ asset('storage/'.$file->file_path) }}"
                        alt="{{ $file->original_name }}"
                        style="
                            width:100%;
                            height:180px;
                            object-fit:cover;
                        ">

                    <div style="padding:15px;">

                        <strong style="
                            display:block;
                            margin-bottom:8px;
                            word-break:break-word;
                        ">
                            {{ $file->original_name }}
                        </strong>

                        <small style="color:#666;">
                            {{ number_format($file->file_size/1024,2) }} KB
                        </small>

                        <br><br>

                        <a href="{{ route('download', $file->id) }}" class="btn">
                            ⬇ Download
                        </a>

                        <form
                            action="{{ route('favorite.toggle',$file->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('PUT')

                            <button class="btn" type="submit">

                                @if($file->is_favorite)
                                    ⭐
                                @else
                                    ☆
                                @endif

                            </button>

                        </form>

                        <form
                            action="{{ route('delete',$file->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn"
                                type="submit"
                                onclick="return confirm('Move image to Trash?')">

                                🗑

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div style="text-align:center;padding:60px;">

            <h3>No images found.</h3>

            <p>
                Upload JPG, PNG, WEBP or GIF images to see them here.
            </p>

        </div>

    @endif

</div>

@endsection