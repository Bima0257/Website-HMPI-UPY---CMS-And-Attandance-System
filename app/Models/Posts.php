<?php

namespace App\Models;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

class Posts extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at'];


    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }



    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(function ($q) use ($search) {
                // Pencarian di judul dan body post
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                    // Pencarian di author (username)
                    ->orWhereHas('author', function ($q2) use ($search) {
                        $q2->where('username', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%'); // Jika ada kolom name
                    })
                    // Pencarian di category (nama atau slug)
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%')
                            ->orWhere('slug', 'like', '%' . $search . '%');
                    });
            })
        );
        $query->when(
            $filters['category'] ?? false,
            fn($query, $category) =>
            $query->whereHas(
                'category',
                fn($query) =>
                $query->where('slug', $category)
            )
        );
        $query->when(
            $filters['author'] ?? false,
            fn($query, $author) =>
            $query->whereHas(
                'author',
                fn($query) =>
                $query->where('username', $author)
            )
        );
    }
}
