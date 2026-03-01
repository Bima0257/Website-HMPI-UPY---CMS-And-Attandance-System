<?php

namespace App\Http\Controllers;

use App\Models\DataMember;
use App\Models\QrCode;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QrCode::with('member', 'division')->get();
        $member = DataMember::whereDoesntHave('qrcode')->get();
        return view('dashboard.super-admin.presensi.qr_code.index', [
            'title' => 'Qr Codes Data',
            'member' => $member,
            'data' => $data
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
        if (!$request->filled('member_id')) {
            return redirect()->back()->with('error', 'Semua member sudah memiliki QR Code!!');
        }

        $request->validate([
            'member_id' => 'required|exists:data_members,id'
        ]);

        $this->generateQrCode($request->member_id);

        return redirect()->back()->with('success', 'QR Code berhasil dibuat');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $qrCode = QrCode::findOrFail($id);

        // Hapus file gambar jika ada
        if ($qrCode->qr_image && Storage::disk('public')->exists($qrCode->qr_image)) {
            Storage::disk('public')->delete($qrCode->qr_image);
        }

        $qrCode->delete();

        return redirect()->back()->with('success', 'QR Code berhasil dihapus');
    }

    public function destroyAll()
    {
        $qrCodes = QrCode::all();

        foreach ($qrCodes as $qrCode) {
            // Hapus file gambar jika ada
            if ($qrCode->qr_image && Storage::disk('public')->exists($qrCode->qr_image)) {
                Storage::disk('public')->delete($qrCode->qr_image);
            }

            $qrCode->delete();
        }

        return redirect()->back()->with('success', 'Semua data QR Code berhasil dihapus');
    }

    private function generateQrCode($memberId)
    {
        $member = DataMember::with('division')->findOrFail($memberId);

        // Generate unique QR data
        $qrData = 'MEMBER-' . Str::upper(Str::random(8)) . '-' . $member->id;

        // API URL dari GoQR.me
        $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/';
        $params = [
            'data' => $qrData,
            'size' => '200x200',
            'format' => 'png'
        ];

        // Download QR code
        $url = $apiUrl . '?' . http_build_query($params);
        $imageContent = file_get_contents($url);

        // Simpan gambar ke storage
        $imageName = 'qrcodes/' . time() . '-' . $member->id . '.png';
        Storage::disk('public')->put($imageName, $imageContent);

        // Simpan data QR ke database
        QrCode::create([
            'member_id' => $member->id,
            'nama' => $member->nama,
            'divisi' => $member->division->nama_divisi ?? '-',
            'jabatan' => $member->jabatan,
            'qr_data' => $qrData,
            'qr_image' => $imageName
        ]);
    }


    public function generateAll()
    {
        $members = DataMember::whereDoesntHave('qrcode')->get();

        if ($members->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Semua QR Code sudah dibuat.',
            ], 200);
        }

        foreach ($members as $member) {
            $this->generateQrCode($member->id);  // Pastikan fungsi generateQrCode berjalan dengan baik
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua QR Code berhasil dibuat!',
            'redirectUrl' => url('/dashboard/qrcodes'),
        ]);
    }


    public function downloadAll()
    {
        $qrCodes = QrCode::all();

        if ($qrCodes->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada QR Code yang tersedia untuk didownload.');
        }

        // Nama file zip, bisa pakai timestamp supaya unik
        $zipFileName = 'all_qrcodes_' . now()->format('Ymd_His') . '.zip';

        // Path sementara untuk zip file di storage/app/temp atau storage/temp
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        // Pastikan folder temp ada
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            foreach ($qrCodes as $qr) {
                $filePath = storage_path('app/public/' . $qr->qr_image);

                if (file_exists($filePath)) {
                    // Tambahkan file ke zip
                    // Nama dalam zip bisa kamu bikin lebih rapi, misal "NamaMember.png"
                    $fileNameInZip = 'QR_' . Str::slug($qr->nama) . '.png';
                    $zip->addFile($filePath, $fileNameInZip);
                }
            }

            $zip->close();

            // Download dan hapus zip setelah selesai
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
    }
}
