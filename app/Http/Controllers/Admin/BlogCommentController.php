<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index()
    {
        // Get latest comments with pagination
        $comments = BlogComment::with('blog')->latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Display the specified comment.
     */
    public function show($id)
    {
        $comment = BlogComment::with('blog')->findOrFail($id);

        return view('admin.comments.show', compact('comment'));
    }
    public function edit($id)
{
    $comment = BlogComment::with('blog')->findOrFail($id);
    return view('admin.comments.edit', compact('comment'));
}

public function update(Request $request, $id)
{
    $comment = BlogComment::findOrFail($id);

    $data = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|max:150',
        'comment' => 'required|string|max:2000',
        'status'  => 'required|in:pending,approved,spam',
    ]);

    $comment->update($data);

    return redirect()
        ->route('admin.comments.index')
        ->with('success', 'Comment updated successfully.');
}


    /**
     * Remove the specified comment from storage.
     */
    public function destroy($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }
}
