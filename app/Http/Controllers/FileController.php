<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Storage\StorageManager;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Show all files of the logged-in user.
     */
    public function index()
    {
        $files = File::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('files', compact('files'));
    }

public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|max:51200',
    ]);

    $uploadedFile = $request->file('file');

    $storage = new StorageManager();

    $result = $storage->driver()->upload($uploadedFile);

    File::create([
        'user_id' => Auth::id(),
        'original_name' => $uploadedFile->getClientOriginalName(),
        'stored_name' => $result['stored_name'],
        'file_path' => $result['file_path'],
        'telegram_file_id' => $result['telegram_file_id'],
        'telegram_message_id' => $result['telegram_message_id'],
        'storage_driver' => $result['storage_driver'],
        'mime_type' => $uploadedFile->getClientMimeType(),
        'file_size' => $uploadedFile->getSize(),
        'checksum' => hash_file('sha256', $uploadedFile->getRealPath()),
    ]);

    return redirect()->back()->with('success', 'File uploaded successfully!');
}
public function download($id)
{
    $file = File::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $storage = new StorageManager();

    return $storage->driver()->download($file);
}

public function destroy($id)
{
    $file = File::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $file->delete();

    return redirect()->back()->with('success', 'File moved to Trash successfully!');
}

public function trash()
{
    $files = File::onlyTrashed()
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('trash', compact('files'));
}

public function restore($id)
{
    $file = File::onlyTrashed()
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $file->restore();

    return redirect()->route('trash')
        ->with('success', 'File restored successfully!');
}
public function forceDelete($id)
{
    $file = File::onlyTrashed()
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Delete the physical file
    if (Storage::disk('public')->exists($file->file_path)) {
        Storage::disk('public')->delete($file->file_path);
    }

    // Permanently delete the database record
    $file->forceDelete();

    return redirect()->route('trash')
        ->with('success', 'File deleted permanently!');
}

public function gallery()
{
    $files = File::where('user_id', Auth::id())
        ->where(function ($query) {
            $query->where('mime_type', 'like', 'image/%');
        })
        ->latest()
        ->get();

    return view('gallery', compact('files'));
}


public function toggleFavorite($id)
{
    $file = File::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $file->is_favorite = !$file->is_favorite;
    $file->save();

    return redirect()->back()->with('success', 'Favorite updated successfully!');
}

public function rename(Request $request, $id)
{
    $request->validate([
        'original_name' => 'required|string|max:255',
    ]);

    $file = File::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $file->original_name = $request->original_name;
    $file->save();

    return redirect()->back()->with('success', 'File renamed successfully!');
}

public function favorites()
{
    $files = File::where('user_id', Auth::id())
        ->where('is_favorite', true)
        ->latest()
        ->get();

    return view('favorites', compact('files'));
}

public function recent()
{
    $files = File::where('user_id', Auth::id())
        ->latest()
        ->take(10)
        ->get();

    return view('recent', compact('files'));
}

public function search(Request $request)
{
    $search = $request->search;

    $files = File::where('user_id', Auth::id())
        ->where('original_name', 'LIKE', "%{$search}%")
        ->latest()
        ->get();

    return view('files', compact('files', 'search'));
}

}