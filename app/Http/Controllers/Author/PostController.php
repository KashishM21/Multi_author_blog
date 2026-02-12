<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $allowedStatuses = ['published', 'draft', 'pending', 'rejected'];

        $query = Post::ownedByCurrentUser();

        if (in_array($status, $allowedStatuses)) {
            $query->{$status}();
        }

        $posts = $query->latest()->get();

        return view('author.posts.index', compact('posts', 'status'));
    }

    public function create()
    {
        return view('author.posts.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
        }

        $status = $request->has('save_draft') ? 'draft' : 'published';

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            // 'content' => $request->content,
            'featured_image' => $imagePath,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);

        return redirect()->route('author.posts.index')
            ->with('success', 'Post ' . ($status === 'draft' ? 'saved as draft' : 'published') . ' successfully!');
    }

    public function edit($id)
    {
        $post = Post::ownedByCurrentUser()->findOrFail($id);
        return view('author.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // local scope 
        $post = Post::ownedByCurrentUser()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->title !== $post->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $post->slug = $slug;
        }

        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('posts', 'public');
        }

        $status = $request->has('save_draft') ? 'draft' : 'published';

        $post->title = $request->title;
        $post->summary = $request->summary;
        // $post->content = $request->content;
        $post->status = $status;

        if ($status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }

        $post->save();

        return redirect()->route('author.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::ownedByCurrentUser()->findOrFail($id);
        $post->delete();

        return redirect()->route('author.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}
