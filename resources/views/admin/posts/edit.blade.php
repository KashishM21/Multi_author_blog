@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endsection

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('admin.posts.index') }}" class="btn">Back to Posts</a>
        <h1 class="page-title">Edit Post</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="edit-form">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title" class="form-label">Title *</label>
                <input type="text" name="title" id="title" class="form-control" 
                       value="{{ old('title', $post->title) }}" required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="summary" class="form-label">summary</label>
                <textarea name="summary" id="summary" class="form-control" rows="2" 
                          placeholder="Brief summary of your post...">{{ old('summary', $post->summary) }}</textarea>
                <div class="form-text">A short description that appears in post listings</div>
                @error('summary')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Content </label>
                <div class="editor-content" id="content-editor">{!! old('content', $post->content) !!}</div>
                <textarea name="content" id="content-editor-hidden">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Featured Image</label>
                @if($post->featured_image)
                    <div>
                        <img src="{{ Storage::url($post->featured_image) }}" alt="Current featured image" >
                    </div>
                @endif
                <div class="file-upload">
                    <input type="file" name="featured_image" accept="image/*" onchange="handleFileUpload(this, 'image-preview')">
                    <div class="file-upload-text">Click or drag to upload a new image</div>
                </div>
                @if(!$post->featured_image)
                    <img id="image-preview" >
                @endif
                @error('featured_image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn ">Update Post</button>
                <a href="{{ route('admin.posts.show', $post) }}" class="btn">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    editor.init('content-editor');
    
    document.getElementById('edit-form').addEventListener('submit', function() {
        document.getElementById('content-editor-hidden').value = document.getElementById('content-editor').innerHTML;
    });
});
</script>
@endpush
@endsection
