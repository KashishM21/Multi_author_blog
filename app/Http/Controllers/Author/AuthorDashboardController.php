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
            ->limit(4)
            ->get();

        // Pass to view
        return view('author.dashboard', compact('recentPosts'));
    }
}
