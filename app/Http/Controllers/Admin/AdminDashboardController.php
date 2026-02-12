<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'pending_posts' => Post::pending()->count(),
            'published_posts' => Post::published()->count(),
            'draft_posts' => Post::draft()->count(),
            'total_users'=>User::count(),
            "total_authors"=>User::where('role','author')->count(),

        ];
        $pendingPosts = Post::with('user')
            ->pending()
            ->latest()
            ->take(5)
            ->get();
        $recentPosts = Post::with('user')
            ->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats','pendingPosts','recentPosts'));
    }
}
