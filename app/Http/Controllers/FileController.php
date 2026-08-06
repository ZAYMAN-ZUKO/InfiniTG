<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\Storage\StorageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index()
    {
        $folders = Folder::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $files = File::where('user_id', Auth::id())
            ->whereNull('folder_id')
            ->latest()
            ->paginate(config('infinitg.pagination'));

        return view('files', compact('folders', 'files'));
    }

    public function upload(UploadFileRequest $request)
    {
        $uploadedFile = $request->file('file');

        $storage = new StorageManager();

        $result = $storage->driver()->upload($uploadedFile);

        File::create([
            'user_id' => Auth::id(),
            'folder_id' => $request->validated('folder_id'),
            'original_name' => $uploadedFile->getClientOriginalName(),
            'stored_name' => $result['stored_name'],
            'file_path' => $result['file_path'],
            'telegram_file_id' => $result['telegram_file_id'] ?? null,
            'telegram_message_id' => $result['telegram_message_id'] ?? null,
            'telegram_chat_id' => $result['telegram_chat_id'] ?? null,
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

        $tempPath = $storage->download($file);

        while (ob_get_level()) {
            ob_end_clean();
        }

        return response()->download(
            $tempPath,
            $file->original_name,
            [
                'Content-Type' => $file->mime_type,
            ]
        )->deleteFileAfterSend(true);
    }

    public function preview($id)
    {
        $file = File::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $storage = new StorageManager();

        $tempPath = $storage->download($file);

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: ' . $file->mime_type);
        header('Content-Length: ' . filesize($tempPath));

        readfile($tempPath);

        exit;
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
            ->paginate(config('infinitg.pagination'));

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

        $storage = new StorageManager();

        $storage->driver()->delete($file);

        $file->forceDelete();

        return redirect()->route('trash')
            ->with('success', 'File deleted permanently!');
    }

    public function gallery()
    {
        $files = File::where('user_id', Auth::id())
            ->where('mime_type', 'like', 'image/%')
            ->latest()
            ->paginate(config('infinitg.pagination'));

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
            ->paginate(config('infinitg.pagination'));

        return view('favorites', compact('files'));
    }

    public function recent()
    {
        $files = File::where('user_id', Auth::id())
            ->latest()
            ->paginate(config('infinitg.pagination'));

        return view('recent', compact('files'));
    }

    public function search(Request $request)
    {
        $search = trim($request->search);

        if ($search === '') {
            return redirect()->route('files.index');
        }

        $folders = Folder::where('user_id', Auth::id())
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $files = File::where('user_id', Auth::id())
            ->where('original_name', 'LIKE', "%{$search}%")
            ->latest()
            ->paginate(config('infinitg.pagination'))
            ->withQueryString();

        return view('files', compact('folders', 'files', 'search'));
    }
}