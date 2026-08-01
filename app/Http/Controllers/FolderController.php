<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     * Create a new folder.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        Folder::create([
            'user_id'   => Auth::id(),
            'parent_id' => $request->parent_id,
            'name'      => trim($request->name),
        ]);

        return back()->with(
            'success',
            'Folder created successfully.'
        );
    }

    /**
     * Rename folder.
     */
    public function update(Request $request, Folder $folder)
    {
        abort_if(
            $folder->user_id !== Auth::id(),
            403
        );

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder->update([
            'name' => trim($request->name),
        ]);

        return back()->with(
            'success',
            'Folder renamed successfully.'
        );
    }



public function show(Folder $folder)
{
    abort_if($folder->user_id !== Auth::id(), 403);

    $folders = $folder->children()->latest()->get();

    $files = $folder->files()->latest()->get();

    return view('folder', compact(
        'folder',
        'folders',
        'files'
    ));
}

    /**
     * Delete folder.
     */
    public function destroy(Folder $folder)
    {
        abort_if(
            $folder->user_id !== Auth::id(),
            403
        );

        // Prevent deleting folders that contain subfolders
        if ($folder->children()->exists()) {

            return back()->withErrors(
                'Folder contains subfolders.'
            );

        }

        // Prevent deleting folders that contain files
        if ($folder->files()->exists()) {

            return back()->withErrors(
                'Folder contains files.'
            );

        }

        $folder->delete();

        return back()->with(
            'success',
            'Folder deleted successfully.'
        );
    }
}