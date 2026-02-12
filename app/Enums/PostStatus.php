<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'pending',
            self::PUBLISHED => 'published',
            self::REJECTED => 'rejected',
        };
    }
}
