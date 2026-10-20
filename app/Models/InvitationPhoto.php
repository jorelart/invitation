<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InvitationPhoto extends Model
{
    protected $fillable = [
        'slot',
        'path',
        'caption',
        'sort_order',
        'width',
        'height',
    ];

    public function getUrlAttribute(): string
    {
        return str_starts_with($this->path, 'assets/')
            ? asset($this->path)
            : Storage::disk('public')->url($this->path);
    }
}
