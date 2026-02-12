<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} | Multi-Author Blog</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post_show.css') }}">
</head>
<body>

    @include('layouts.header')

    <main class="post-container">
        <a href="{{ route('home') }}" class="back-link"> Back to Home</a>

        <article class="post-article">
            <div class="post-meta">
                <span class="post-category">Blog Post</span>
                <span class="post-date">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                </span>
            </div>

            <h1 class="post-title">{{ $post->title }}</h1>

            <div class="post-author">
                <div class="author-avatar">
                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                </div>
                <div class="author-info">
                    <div class="author-name">
                        {{ $post->user->name ?? 'Anonymous' }}
                    </div>
                </div>
            </div>

            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $post->title }}"
                     class="post-featured-image">
            @endif

            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>
        </article>

     
    </main>
       @if($authorPosts->count() > 0)
            <section class="author-posts-section">
                <h2 class="author-posts-title">
                    More from {{ $post->user->name ?? 'this author' }}
                </h2>

                <div class="author-posts-grid">
                    @foreach($authorPosts as $aPost)
                        <a href="{{ route('post.show', $aPost->slug) }}"
                           class="author-post-card">

                            @if($aPost->featured_image)
                                <img src="{{ asset('storage/' . $aPost->featured_image) }}"
                                     alt="{{ $aPost->title }}"
                                     class="author-post-image">
                            @else
                                <div class="author-post-placeholder">📝</div>
                            @endif

                            <div class="author-post-content">
                                <h3 class="author-post-title">{{ $aPost->title }}</h3>
                                <span class="author-post-date">
                                    {{ $aPost->published_at ? $aPost->published_at->format('M d, Y') : $aPost->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

</body>
</html>
