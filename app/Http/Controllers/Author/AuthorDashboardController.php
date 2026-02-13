<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        $recentPosts = Post::ownedByCurrentUser()
            ->latest()
            ->paginate(6);
        // Pass to view
        return view('author.dashboard', compact('recentPosts'));
    }
}
