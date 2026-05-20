<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable; // Ya está importado

class Post extends Model
{
    // AQUÍ ESTÁ EL CAMBIO: Agregamos Auditable al lado de HasFactory
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'views',
        'published_at'
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
