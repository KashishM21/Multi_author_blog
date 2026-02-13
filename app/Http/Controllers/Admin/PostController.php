<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user')->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $posts = $query->get();
        return view('admin.posts.index', compact('posts'));
    }
    public function show(Post $post)
    {
        $post->load('user');
        return view('admin.posts.show', compact('post'));
    }
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:draft,pending,published,rejected']);

        $post = Post::findOrFail($id);
        $post->status = $request->status;

        if ($request->status === 'published') {
            if (!$post->published_at) {
                $post->published_at = now();
            }
        } else {
            // If it's no longer published, we might want to clear published_at
            // $post->published_at = null; 
        }

        $post->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Post status updated.']);
        }

        return redirect()->back()->with('success', 'Post status updated.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
