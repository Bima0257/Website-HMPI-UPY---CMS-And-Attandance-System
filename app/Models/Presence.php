<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $guarded = ['id'];
    
    public function qrCode()
    {
        return $this->belongsTo(QrCode::class, 'qr_code_id');
    }
}
