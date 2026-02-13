<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Author Blog</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
</head>

<body>

    @include('layouts.header')

    <div class="container">

        <section class="home-header">
            <h1 class="welcome-title">Welcome to Multi-Author Blog</h1>
            <p class="welcome-text">
                Discover insightful articles from our talented authors. Fresh perspectives on technology, design, and
                more.
            </p>

            @guest
                <a href="{{ route('register') }}" class="btn ">
                    Start Writing
                </a>
            @else
                <a href="#posts" class="btn ">
                    Explore Posts
                </a>
            @endguest
        </section>
        <section id="posts" class="posts-section">
            @if ($posts->count() > 0)
                <div class="posts-grid">
                    @foreach ($posts as $post)
                        <div class="post-card">
                            <div class="post-image">
                                @if ($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                                @else
                                    <div class="post-image-placeholder">
                                        <span>📝</span>
                                    </div>
                                @endif
                            </div>
                            <div class="post-content">
                                <span
                                    class="post-date">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                <h3 class="post-title">{{ $post->title }}</h3>
                                <p class="post-summary">{{ Str::limit($post->summary ?? $post->content, 100) }}</p>
                                <div class="post-footer">
                                    <div class="post-author">
                                        <span
                                            class="author-avatar">{{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}</span>
                                        <span class="author-name">{{ $post->user->name ?? 'Anonymous' }}</span>
                                    </div>
                                    <a href="{{ route('post.show', $post->slug) }}" class="read-more">Read More</a>
                                    {{-- , $post->slug --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-posts">
                    <h2>No posts yet</h2>
                    <p>Be the first to share your thoughts!</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn ">Start Writing</a>
                    @else
                        <a href="{{ route('author.posts.create') }}" class="btn ">Create Your First Post</a>
                    @endguest
                </div>
            @endif
        </section>
        <div class="pagination">
            {{ $posts->links() }}
        </div>
    </div>
</body>
</html>