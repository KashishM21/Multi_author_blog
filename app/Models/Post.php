<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PostStatus;
// use Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'summary',
        'content',
        'featured_image',
        'status',
        'published_at'
    ];
    // casting 
    protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'datetime',
    ];

    // mutator and accessor
    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => ucfirst(strtolower(trim($value))),
        );
    }
    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function author()
    {
        return $this->user();
    }


    public function scopeOwnedByCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::PUBLISHED)
            ->whereNotNull('published_at');
    }
    public function scopeDraft($query)
    {
        return $query->where('status', PostStatus::DRAFT);
    }
    public function scopePending($query)
    {
        return $query->where('status', PostStatus::PENDING);
    }
    public function scopeRejected($query)
    {
        return $query->where('status', PostStatus::REJECTED);
    }
    public function isDraft(): bool
    {
        return $this->status === PostStatus::DRAFT;
    }
    public function isPending(): bool
    {
        return $this->status === PostStatus::PENDING;
    }
    public function isPublished(): bool
    {
        return $this->status === PostStatus::PUBLISHED;
    }
    public function isRejected(): bool
    {
        return $this->status === PostStatus::REJECTED;
    }
}
