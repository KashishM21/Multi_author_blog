@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endsection
@section('content')
    <div class="page-header">
        <h1 class="title">
            All Posts
            <span class="badge">{{ $posts->count() }} posts</span>
        </h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="filters">
        <form action="{{ route('admin.posts.index') }}" method="get" class="filter-form">
            <div class="filter-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All
                    </option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="filter-group search-input">
                <input type="text" name="search" class="form-control" placeholder="Search posts..."
                    value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            @if (request()->hasAny(['status', 'search']))
                <a href="{{ route('admin.posts.index') }}" class="btn ">Clear</a>
            @endif
        </form>
    </div>

    <div class="posts-table-container">
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
                @forelse($posts as $post)
                    <tr data-post-id="{{ $post->id }}">
                        <td>
                            <a href="{{ route('admin.posts.show', $post) }}">
                                {{ Str::limit($post->title, 50) }}
                            </a>
                            @if ($post->summary)
                                <p>
                                    {{ Str::limit($post->summary, 60) }}
                                </p>
                            @endif
                        </td>
                        <td>
                            <div class="author">
                                <div class="author-avatar">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                                <span>{{ $post->user->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $post->status->value }}">{{ $post->status->label() }}</span></td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.posts.show', $post) }}" class="action-btn view"
                                    title="View">View</a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="action-btn edit"
                                    title="Edit">Edit</a>

                                @if ($post->isPending())
                                    <button class="btn" onclick="postActions.approve({{ $post->id }}, this)"
                                        title="Approve">Approve</button>
                                    <button class="btn" onclick="postActions.reject({{ $post->id }}, this)"
                                        title="Reject">Rejected</button>
                                @endif

                                <form id="delete-form-{{ $post->id }}"
                                    action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn delete"
                                        onclick="postActions.delete('delete-form-{{ $post->id }}')"
                                        title="Delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">📝</div>
                                <h3 class="empty-state-title">No posts found</h3>
                                <p class="empty-state-text">Try adjusting your filters</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
