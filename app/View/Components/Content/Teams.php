<?php

namespace App\View\Components\Content;

use Closure;
use App\Models\DataMember;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Teams extends Component
{
    /**
     * Create a new component instance.
     */
    public $members;
    public function __construct()
    {
        $this->members = DataMember::with('division')
            ->where('status', 'Aktif')
            ->whereIn('jabatan', ['KETUA', 'WAKIL KETUA', 'KETUA DIVISI', 'SEKRETARIS', 'BENDAHARA', 'ANGGOTA'])
            ->orderByRaw("FIELD(jabatan, 'KETUA', 'WAKIL KETUA', 'SEKRETARIS', 'BENDAHARA', 'KETUA DIVISI', 'ANGGOTA')")
            ->limit(8)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content.teams');
    }
}
