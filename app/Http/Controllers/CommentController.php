<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Image;

class CommentController extends Controller
{
    public function index($type, $id)
    {
        if ($type === 'images') {
            $image = \App\Models\Image::with(['comments.user', 'comments.replies.user'])->findOrFail($id);
            $folder = $image->folder;
            return view('images.show', compact('image', 'folder'));
        } elseif ($type === 'folders') {
            $folder = \App\Models\Folder::with(['comments.user', 'comments.replies.user'])->findOrFail($id);
            $images = $folder->images()->latest()->get();
            return view('folders.show', compact('folder', 'images'));
        }
        abort(404);
    }

    public function store(Request $request, $type, $id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($type === 'images') {
            $commentable_id = $id;
            $commentable_type = \App\Models\Image::class;
        } elseif ($type === 'folders') {
            $commentable_id = $id;
            $commentable_type = \App\Models\Folder::class;
        } else {
            abort(404);
        }

        \App\Models\Comment::create([
            'commentable_id' => $commentable_id,
            'commentable_type' => $commentable_type,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id
        ]);

        return back();
    }
}
