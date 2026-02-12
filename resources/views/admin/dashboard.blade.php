@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection


@section('content')
    <div class="page-header">
        <h1 class="title">Dashboard</h1>
        <span class="badge">Admin</span>
    </div>
    <div class="section">
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_posts'] }}</div>
                    <div class="stat-label">
                        Total Posts
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['pending_posts'] }}</div>

                    <div class="stat-label">
                        Pending Review
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['published_posts'] }}</div>

                    <div class="stat-label">
                        Published
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_users'] }}</div>

                    <div class="stat-label">
                        Total Users
                    </div>
                </div>
            </div>
        </div>
      @if($pendingPosts->count() > 0)
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-body">
        <div class="d-flex justify-between align-center mb-3">
            <h2 style="margin: 0;">Pending Review</h2>
            <a href="{{ route('admin.posts.index', ['status' => 'pending']) }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        
        <div class="table-wrapper" style="box-shadow: none;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingPosts as $post)
                    <tr data-post-id="{{ $post->id }}">
                        <td>
                            <a href="{{ route('admin.posts.show', $post) }}">
                                {{ Str::limit($post->title, 40) }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-center gap-1">
                                <div class="author-avatar">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                                {{ $post->user->name }}
                            </div>
                        </td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.posts.show', $post) }}" class="action-btn view" title="View">👁</a>
                                <button class="action-btn edit" onclick="postActions.approve({{ $post->id }}, this)" title="Approve">✓</button>
                                <button class="action-btn delete" onclick="postActions.reject({{ $post->id }}, this)" title="Reject">✕</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

        <div class="card">
            <div class="card-body">
                <div class="">
                    <h2>Recents Posts</h2>
                    <a href="{{ route('admin.posts.index') }}" class="btn">View All</a>
                </div>
                <div class="">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                     <tbody>
                    @forelse($recentPosts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('admin.posts.show', $post) }}" style="font-weight: 500;">
                                {{ Str::limit($post->title, 40) }}
                            </a>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td><span class="badge badge-{{ $post->status->value }}">{{ $post->status->label() }}</span></td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.posts.show', $post) }}" class="action-btn view" title="View">View</a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="action-btn edit" title="Edit">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" >No posts found</td>
                    </tr>
                    @endforelse
                </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
