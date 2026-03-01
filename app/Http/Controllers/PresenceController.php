<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\LaporanPresensi;
use Illuminate\Support\Facades\DB;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qrcode =  QrCode::all();
        $presence = Presence::with('qrCode')->get();
        return view('dashboard.super-admin.presensi.scanner.index', [
            'title' => 'Presensi',
            'data' => $presence,
            'qrcode' => $qrcode
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $qrData = $request->input('qr_data'); // Dikirim dari scanner
        $qrCode = QrCode::where('qr_data', $qrData)->first();

        if (!$qrCode) {
            return response()->json(['message' => 'QR Code tidak valid.'], 404);
        }

        // Cek apakah sudah presensi hari ini
        $sudahPresensi = Presence::where('qr_code_id', $qrCode->id)
            ->whereDate('tanggal_presensi', now()->toDateString())
            ->exists();

        if ($sudahPresensi) {
            return response()->json(['message' => 'Sudah presensi hari ini.'], 409);
        }

        $waktuMulaiStr = $request->input('waktu_mulai'); // format: 'HH:MM'
        $batasTelatMenit = $request->input('batas_telat');

        // Tidak perlu set timezone karena sudah diatur secara global
        $today = now()->toDateString();
        $waktuMulaiCarbon = Carbon::createFromFormat('Y-m-d H:i', $today . ' ' . $waktuMulaiStr);
        $batasTelatCarbon = $waktuMulaiCarbon->copy()->addMinutes($batasTelatMenit);
        $waktuSekarang = now();

        if ($waktuSekarang->lt($waktuMulaiCarbon)) {
            return response()->json(['message' => 'Presensi belum dimulai.'], 403);
        }

        $status = $waktuSekarang->gt($batasTelatCarbon) ? 'Telat' : 'Hadir';

        try {
            // Simpan presensi
            $presence = Presence::create([
                'qr_code_id' => $qrCode->id,
                'status' => $status,
                'tanggal_presensi' => now()->toDateString(),
                'jam_presensi' => now()->toTimeString(),
                'waktu_mulai' => $waktuMulaiCarbon->format('H:i:s'),
                'batas_telat' => $batasTelatCarbon->format('H:i:s'),
            ]);

            return response()->json([
                'message' => 'Presensi berhasil.',
                'data' => [
                    'nama' => $qrCode->nama,
                    'divisi' => $qrCode->divisi,
                    'jabatan' => $qrCode->jabatan,
                    'status' => $presence->status,
                    'tanggal' => $presence->tanggal_presensi,
                    'jam' => $presence->jam_presensi
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan presensi: ' . $e->getMessage()], 500);
        }
    }


    public function storeManualPresence(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qr_code_id' => 'required|exists:qr_codes,id',
            'status' => 'required|in:Hadir,Terlambat,Izin,Sakit',
            'tanggal_presensi' => 'required|date',
            'jam_presensi' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form_error', true)
                ->with('form_input', $request->all());
        }

        // Cek apakah data presensi sudah ada
        $existing = Presence::where('qr_code_id', $request->qr_code_id)
            ->whereDate('tanggal_presensi', $request->tanggal_presensi)
            ->exists();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Anggota ini sudah melakukan presensi pada hari ini!')
                ->withInput();
        }

        // Simpan data presensi
        Presence::create([
            'qr_code_id' => $request->qr_code_id,
            'status' => $request->status,
            'tanggal_presensi' => $request->tanggal_presensi,
            'jam_presensi' => $request->jam_presensi,
        ]);

        return redirect()->back()->with('success', 'Presensi manual berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        // Kirim data ke modal untuk diedit
        return response()->json([
            'id' => $presence->id,
            'qr_code_id' => $presence->qr_code_id,
            'tanggal_presensi' => $presence->tanggal_presensi,
            'jam_presensi' => $presence->jam_presensi,
            'status' => $presence->status
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence)
    {
        // Validasi input
        $request->validate([
            'qr_code_id' => 'required|exists:qr_codes,id',
            'jam_presensi' => 'required|date_format:H:i',
            'status' => 'required|in:Hadir,Izin,Alpha',
        ]);


        // Update data presensi
        $presence->qr_code_id = $request->qr_code_id;
        $presence->jam_presensi = $request->jam_presensi;
        $presence->status = $request->status; // Update status
        $presence->save();

        return redirect()->route('presences.index')->with('success', 'Presensi berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence)
    {

        $presence->delete();

        return redirect()->back()->with('success', 'Data presensi berhasil dihapus.');
    }

    public function deleteAll()
    {
        Presence::truncate();

        return redirect()->back()->with('success', 'Semua data presensi berhasil dihapus.');
    }


    public function arsipkanPresensi()
    {
        if (DB::transactionLevel() > 0) {
            DB::rollBack();
        }
        try {
            $presences = Presence::all();

            foreach ($presences as $save) {
                LaporanPresensi::create([
                    'qr_code_id' => $save->qr_code_id,
                    'status' => $save->status,
                    'tanggal_presensi' => $save->tanggal_presensi,
                    'jam_presensi' => $save->jam_presensi,
                    'waktu_mulai' => $save->waktu_mulai,
                    'batas_telat' => $save->batas_telat,
                    'created_at' => $save->created_at,
                    'updated_at' => $save->updated_at,
                ]);
            }

            Presence::truncate();
            DB::commit();

            return redirect()->route('laporanPresensi')->with('success', 'Data berhasil Di Arsipkan');
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
