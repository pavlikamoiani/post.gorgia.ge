<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Image;

class CommentController extends Controller
{
    public function index($imageId)
    {
        $image = \App\Models\Image::with(['comments.user', 'comments.replies.user'])->findOrFail($imageId);
        $folder = $image->folder;
        return view('images.show', compact('image', 'folder'));
    }

    public function store(Request $request, $imageId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'image_id' => $imageId,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id
        ]);

        return back();
    }
}
