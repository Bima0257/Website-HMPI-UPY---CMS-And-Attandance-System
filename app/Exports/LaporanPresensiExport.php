<?php

namespace App\Exports;

use App\Models\LaporanPresensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPresensiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return LaporanPresensi::with('qrCode')
            ->where('tanggal_presensi', $this->tanggal)
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->qrCode->nama ?? '-',
                    'Jabatan' => $item->qrCode->jabatan ?? '-',
                    'Tanggal' => $item->tanggal_presensi,
                    'Waktu Presensi' => $item->jam_presensi,
                    'Waktu Mulai' => $item->waktu_mulai ?? '-',
                    'Batas Telat' => $item->batas_telat ?? '-',
                    'Status' => $item->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Jabatan',
            'Tanggal',
            'Waktu Presensi',
            'Waktu Mulai',
            'Batas Telat',
            'Status',
        ];
    }
}
