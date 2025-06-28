<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Post;


class Category extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'meta_desc'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
