<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QrCode extends Model
{
    protected $guarded = ['id'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function presence(): HasMany
    {
        return $this->hasMany(Presence::class, 'qr_code_id');
    }
    public function archive(): HasMany
    {
        return $this->hasMany(Presence::class, 'qr_code_id');
    }
}
