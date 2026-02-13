<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->with('user')
            // ->take(12)
            // ->get();
            ->paginate((6));

        return view('home', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with('user')
            ->firstOrFail();

        $authorPosts = Post::where('user_id', $post->user_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('post.show', compact('post', 'authorPosts'));
    }
}
