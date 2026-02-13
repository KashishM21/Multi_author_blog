@extends('layouts.author')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/posts_add.css') }}">
@endsection

@section('content')
    <div class="section">
        <div class="page-header">
            <h1 class="title">Edit Post</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('author.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter post title" value="{{ old('title', $post->title) }}" required>
                </div>
                <div class="form-group">
                    <label for="summary">Summary</label>
                    <textarea id="summary" name="summary" class="form-control" rows="3"
                        placeholder="Write a short summary of your post...">{{ old('summary', $post->summary) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="10"
                        placeholder="Write your post content here..." required>{{ old('content', $post->content) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="featured_image">Featured Image</label>
                    @if ($post->featured_image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current featured image">
                            <p>Current image</p>
                        </div>
                    @endif
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Submit for Review</button>
                    <button type="submit" name="save_draft" value="1" class="btn btn-secondary">Save as Draft</button>
                    <a href="{{ route('author.posts.index') }}" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
