@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold">
                📁 {{ $folder->name }}
            </h1>

            <p class="text-gray-500">
                Folder Contents
            </p>
        </div>

        <a href="{{ route('files.index') }}"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
            ← Back
        </a>

    </div>


    {{-- Subfolders --}}
    @if($folders->count())

        <h2 class="text-xl font-semibold mb-4">
            Folders
        </h2>

        <div class="grid grid-cols-4 gap-4 mb-8">

            @foreach($folders as $subfolder)

                <a href="{{ route('folders.show',$subfolder) }}"
                   class="border rounded-xl p-5 hover:bg-gray-50">

                    📁

                    <div class="font-semibold mt-2">
                        {{ $subfolder->name }}
                    </div>

                </a>

            @endforeach

        </div>

    @endif


    {{-- Files --}}
    <h2 class="text-xl font-semibold mb-4">
        Files
    </h2>

    @if($files->count())

        <table class="w-full">

            <thead>

            <tr class="border-b">

                <th class="text-left py-3">Name</th>
                <th>Size</th>
                <th>Type</th>

            </tr>

            </thead>

            <tbody>

            @foreach($files as $file)

                <tr class="border-b">

                    <td class="py-3">

                        {{ $file->original_name }}

                    </td>

                    <td>

                        {{ number_format($file->file_size/1024,2) }} KB

                    </td>

                    <td>

                        {{ $file->mime_type }}

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @else

        <div class="bg-white rounded-xl p-10 text-center text-gray-500">

            This folder is empty.

        </div>

    @endif

</div>

@endsection