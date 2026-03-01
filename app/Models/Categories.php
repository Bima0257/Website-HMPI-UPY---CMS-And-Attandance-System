<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts;
use Cviebrock\EloquentSluggable\Sluggable;

class Categories extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(Posts::class, 'category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
