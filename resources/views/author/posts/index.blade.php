@extends('layouts.author')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endsection

@section('content')
    <div class="section">
        <div class="page-header">
            <h1 class="title">My Posts</h1>
            <a href="{{ route('author.posts.create') }}" class="btn btn-new"> New Post</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-section">
            <form method="GET" action="{{ route('author.posts.index') }}" class="filter-form">
                <label for="status">Status:</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                    <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </form>
        </div>

        @if ($posts->count() > 0)
            <div class="posts-table-container">
                <table class="posts-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td class="post-title">{{ $post->title }}</td>
                                <td>
                                    <span class="status-badge {{ $post->status->value }}">
                                        {{ ucfirst($post->status->label()) }}
                                    </span>
                                </td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td class="actions">
                                    <a href="{{ route('author.posts.edit', $post->id) }}" class="btn-action edit">Edit</a>
                                    <form action="{{ route('author.posts.destroy', $post->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>No posts found</h3>
                <p>Start writing your first blog post!</p>
                <a href="{{ route('author.posts.create') }}" class="btn btn-primary">Create New Post</a>
            </div>
        @endif
    </div>
@endsection
