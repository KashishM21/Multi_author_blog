@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endsection

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('admin.posts.index') }}" class="btn">Back to Posts</a>
        <h1 class="page-title">{{ $post->title }}</h1>
    </div>
    <div class="">
        @if($post->isPending())
            <button class="btn " onclick="postActions.approve({{ $post->id }}, this)">
                Approve & Publish
            </button>
            <button class="btn" onclick="postActions.reject({{ $post->id }}, this)">
                 Reject
            </button>
        @endif
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn"> Edit</a>
    </div>
</div>

<div >
    <div class="card">
        <div class="card-body">
            @if($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}">
                            @endif
            
            @if($post->excerpt)
                <div>
                    <strong>Excerpt:</strong>
                    <p>{{ $post->excerpt }}</p>
                </div>
            @endif
            
            <div class="post-content">
                {!! $post->content !!}
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card-body">
                <h3>Post Details</h3>
                
                <div >
                    <label >Status</label>
                    <div><span class="badge badge-{{ $post->status->value }}">{{ $post->status->label() }}</span></div>
                </div>
                
                <div>
                    <label >Author</label>
                    <div class="">
                        <div class="author-avatar">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <span>{{ $post->user->name }}</span>
                    </div>
                </div>
                
                <div>
                    <label >Slug</label>
                    <div"><code>{{ $post->slug }}</code></div>
                </div>
                
                <div>
                    <label >Created</label>
                    <div>{{ $post->created_at->format('M d, Y \a\t H:i') }}</div>
                </div>
                
                @if($post->published_at)
                <div>
                    <label >Published</label>
                    <div>{{ $post->published_at->format('M d, Y \a\t H:i') }}</div>
                </div>
                @endif
            </div>
        </div>
        

    </div>
</div>
@endsection
