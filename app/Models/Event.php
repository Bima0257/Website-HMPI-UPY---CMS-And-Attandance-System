<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    protected $guarded = ['id'];
    protected $with = ['ketuaPelaksana'];

    public function ketuaPelaksana()
    {
        return $this->belongsTo(DataMember::class, 'ketua_pelaksana_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhereHas('divisi', function ($q) use ($search) {
                        $q->where('nama_divisi', 'like', '%' . $search . '%'); // Cari berdasarkan nama divisi
                    });
            });
        });
    }

    public function getRouteKeyName()
    {
        return 'judul';
    }
}
