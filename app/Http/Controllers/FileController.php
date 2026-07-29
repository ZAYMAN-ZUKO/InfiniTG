<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Upload a new file.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|max:51200',
        ]);

        $uploadedFile = $request->file('file');

        $path = $uploadedFile->store('uploads', 'public');

        File::create([
            'user_id'       => Auth::id(),
            'file_name'     => time().'_'.$uploadedFile->getClientOriginalName(),
            'original_name' => $uploadedFile->getClientOriginalName(),
            'file_path'     => $path,
            'mime_type'     => $uploadedFile->getClientMimeType(),
            'file_size'     => $uploadedFile->getSize(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }
public function download($id)
{
    $file = File::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $path = storage_path('app/public/' . $file->file_path);

    return response()->download($path, $file->original_name);
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