<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'slug', 'published_at', 'status','extra'];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
        'extra' => 'array',
    ];

    // Generate slug automatically
    public static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title) . '-' . uniqid();
        });
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to filter published blogs
    public function scopePublished($query)
    {
        return $query->where('status', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
