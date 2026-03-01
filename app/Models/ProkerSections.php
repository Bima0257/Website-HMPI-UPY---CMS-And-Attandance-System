<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProkerSections extends Model
{
    protected $guarded = ['id'];

    protected $with = ['event'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }
}
