<?php

namespace App\Http\Controllers;

use App\Models\LaporanPresensi;
use Illuminate\Http\Request;
use App\Exports\LaporanPresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPresensiController extends Controller
{
    function index()
    {

        $data = LaporanPresensi::select('tanggal_presensi')
            ->distinct()
            ->orderByDesc('tanggal_presensi')
            ->get();

        return view('dashboard.super-admin.presensi.laporan-presensi.index', [
            'title' => 'Laporan Presensi',
            'data' => $data
        ]);
    }

    public function show($tanggal)
    {
        // Ambil semua laporan presensi untuk tanggal yang dipilih
        $laporan = LaporanPresensi::with('qrCode')->where('tanggal_presensi', $tanggal)->get();

        return view('dashboard.super-admin.presensi.show-laporan.index', [
            'title' => 'Laporan Tanggal ' . $tanggal,
            'laporan' => $laporan,
            'tanggal' => $tanggal
        ]);
    }

    public function destroy($id)
    {
        $laporan = LaporanPresensi::findOrFail($id);
        $tanggal = $laporan->tanggal_presensi;

        $laporan->delete();

        return redirect()->route('laporan.show', $tanggal)->with('success', 'Laporan presensi berhasil dihapus.');
    }

    public function destroyByTanggal($tanggal)
    {
        $jumlah = LaporanPresensi::where('tanggal_presensi', $tanggal)->count();

        if ($jumlah === 0) {
            return redirect()->back()->with('error', 'Tidak ada data presensi pada tanggal tersebut.');
        }

        LaporanPresensi::where('tanggal_presensi', $tanggal)->delete();

        return redirect()->route('laporan.show', $tanggal)->with('success', 'Semua laporan presensi pada tanggal ' . $tanggal . ' berhasil dihapus.');
    }

    public function destroyAll()
    {
        // Cek apakah data laporan presensi ada
        $jumlah = LaporanPresensi::count();

        if ($jumlah === 0) {
            return redirect()->back()->with('error', 'Data Arsip Presensi Kosong!');
        }

        // Truncate akan menghapus semua data dan reset auto increment ID
        LaporanPresensi::truncate();

        return redirect()->back()->with('success', 'Semua data laporan presensi berhasil dihapus.');
    }

    public function exportXls($tanggal)
    {
        $namaFile = 'laporan_presensi_' . $tanggal . '.xls';
        return Excel::download(new LaporanPresensiExport($tanggal), $namaFile);
    }

    public function exportPdf($tanggal)
    {
        $laporan = LaporanPresensi::with('qrCode')
            ->where('tanggal_presensi', $tanggal)
            ->get();

        $pdf = Pdf::loadView('dashboard.super-admin.presensi.print.index', [
            'laporan' => $laporan,
            'tanggal' => $tanggal
        ]);

        return $pdf->stream('laporan-presensi-' . $tanggal . '.pdf');
    }
}
