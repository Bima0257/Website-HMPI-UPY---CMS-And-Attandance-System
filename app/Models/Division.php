<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Division extends Model
{
    protected $guarded = ['id'];

    public function events()
    {
        return $this->hasMany(Event::class, 'division_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'divisi_id');
    }

    public function qrCode(): HasOne
    {
        return $this->hasOne(QrCode::class);
    }
}
