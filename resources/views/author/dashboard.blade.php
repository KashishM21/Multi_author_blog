@extends('layouts.author')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection

@section('content')
    <div class="section">
        <div class="page-header">
            <h1 class="title">Dashboard</h1>
            <span class="badge">Author</span>
        </div>
        <div class="grid">
            <div class="grid-card">
                <div class="grid-icon"></div>
                <div class="grid-content">
                    <div class="grid-label">
                        Total Posts
                    </div>
                </div>
            </div>
            <div class="grid-card">
                <div class="grid-icon"></div>
                <div class="grid-content">
                    <div class="grid-label">
                        Draft
                    </div>
                </div>
            </div>
            <div class="grid-card">
                <div class="grid-icon"></div>
                <div class="grid-content">
                    <div class="grid-label">
                        Pending Reviews
                    </div>
                </div>
            </div>
            <div class="grid-card">
                <div class="grid-icon"></div>
                <div class="grid-content">
                    <div class="grid-label">
                        Published
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h2>Quick Actions</h2>
        </div>
        <div>
            <a href="{{ route('author.posts.create') }}" class=" ">Create New Post</a>
            <a href=""> View Draft</a>
            <a href="{{ route('home') }}">View Site</a>
        </div>
    </div>
    <div class="card">
        <h2>My Recent Posts</h2>
        <a href="{{ route('author.posts.index') }}">View All</a>

        <table class="xyz">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPosts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('post.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td>
                            <span class="{{ $post->status->value }}">
                                {{ ucfirst($post->status->label()) }}
                            </span>
                        </td>
                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('author.posts.edit', $post->id) }}">Edit</a>
                            <form action="{{ route('author.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    </div>
@endsection
{{-- @extends('layouts.footer') --}}