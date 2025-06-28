<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $fillable = ['title', 'meta_desc', 'content', 'category_id', 'thumb'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category() : BelongsTo 
    {
        return $this->belongsTo(Category::class);
    }
}
