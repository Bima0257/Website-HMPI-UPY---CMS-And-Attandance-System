<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\ValidationException;

class DataMember extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($member) {
            self::validateRules($member);
        });

        // Saat update
        static::updating(function ($member) {
            self::validateRules($member, $member->id);
        });
    }

    /**
     * Validasi aturan jabatan & divisi
     */
    protected static function validateRules($member, $ignoreId = null)
    {
        // Ketua hanya boleh 1
        if ($member->jabatan === 'KETUA') {
            $exists = self::where('jabatan', 'KETUA')
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            if ($exists) {
                throw ValidationException::withMessages([
                    'jabatan' => 'Hanya boleh ada 1 Ketua!'
                ]);
            }
        }

        // Wakil Ketua hanya boleh 1
        if ($member->jabatan === 'WAKIL KETUA') {
            $exists = self::where('jabatan', 'WAKIL KETUA')
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            if ($exists) {
                throw ValidationException::withMessages([
                    'jabatan' => 'Hanya boleh ada 1 Wakil Ketua!'
                ]);
            }
        }

        // Bendahara hanya boleh 2
        if ($member->jabatan === 'BENDAHARA') {
            $count = self::where('jabatan', 'BENDAHARA')
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->count();
            if ($count >= 2) {
                throw ValidationException::withMessages([
                    'jabatan' => 'Bendahara hanya boleh ada maksimal 2!'
                ]);
            }
        }

        // Sekertaris hanya boleh 2
        if ($member->jabatan === 'SEKERTARIS') {
            $count = self::where('jabatan', 'SEKERTARIS')
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->count();
            if ($count >= 2) {
                throw ValidationException::withMessages([
                    'jabatan' => 'Sekertaris hanya boleh ada maksimal 2!'
                ]);
            }
        }

        // Ketua Divisi hanya boleh 1 per divisi
        if ($member->jabatan === 'KETUA DIVISI') {
            $exists = self::where('jabatan', 'KETUA DIVISI')
                ->where('division_id', $member->division_id)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            if ($exists) {
                throw ValidationException::withMessages([
                    'jabatan' => 'Setiap divisi hanya boleh ada 1 Ketua Divisi!'
                ]);
            }
        }
    }


    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function qrcode(): HasOne
    {
        return $this->hasOne(QrCode::class, 'member_id');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhereHas('division', function ($q2) use ($search) {
                        $q2->where('nama_divisi', 'like', '%' . $search . '%');
                    });
            })
        );
    }
}
