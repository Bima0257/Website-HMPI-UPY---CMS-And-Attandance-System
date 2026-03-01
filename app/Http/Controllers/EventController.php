<?php

namespace App\Http\Controllers;

use App\Models\DataMember;
use App\Models\Division;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level_pengguna === 'Super Admin') {
            // Super Admin bisa melihat semua event
            $events = Event::with(['ketuaPelaksana', 'divisi'])->get();

            // Semua member untuk dropdown
            $dataMembers = DataMember::where('status', 'aktif')
                ->with('division')
                ->orderBy('nama')
                ->get();
        } elseif ($user->level_pengguna === 'Admin') {
            // Admin hanya bisa melihat event miliknya sendiri
            $events = Event::with(['ketuaPelaksana', 'divisi'])
                ->where('user_id', $user->id)
                ->get();

            // Member hanya dari divisi Admin
            $dataMembers = DataMember::where('status', 'aktif')
                ->where('division_id', $user->divisi_id)
                ->with('division')
                ->orderBy('nama')
                ->get();
        } else {
            // Role lain tidak mendapat event
            $events = collect();
            $dataMembers = collect();
        }

        return view('dashboard.super-admin.event-settings.index', [
            'title'       => 'Work Programs',
            'events'      => $events,
            'divisions'   => Division::all(),
            'dataMembers' => $dataMembers,
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
        $user = Auth::user();

        // definisikan rules dasar
        $rules = [
            'judul' => 'required|unique:events',
            'deskripsi' => 'required',
            'ketua_pelaksana_id' => 'required',
            'category' => 'required',
            'tgl_pelaksanaan' => 'required|date',
            'foto' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'background_image' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ];

        // Hanya Super Admin yang boleh pilih division_id manual
        if ($user->level_pengguna === 'Super Admin') {
            $rules['division_id'] = 'required';
        }

        // validasi
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Simpan input file sementara untuk preview ulang
            $formInput = $request->except(['foto', 'background_image']);

            if ($request->hasFile('foto')) {
                $formInput['foto_temp_path'] = $request->file('foto')->store('temp');
            }

            if ($request->hasFile('background_image')) {
                $formInput['background_image_temp_path'] = $request->file('background_image')->store('temp');
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        // Kalau Admin biasa → division_id otomatis
        if ($user->level_pengguna === 'Admin') {
            $validatedData['division_id'] = $user->divisi_id;
        }

        $validatedData['user_id'] = $user->id;

        // upload file
        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('event-image');
        }

        if ($request->file('background_image')) {
            $validatedData['background_image'] = $request->file('background_image')->store('event-image');
        }

        Event::create($validatedData);

        return redirect('/dashboard/event')->with('success', 'Event Has Been Added!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $user = Auth::user();

        if ($user->level_pengguna === 'Super Admin') {
            return view('dashboard.super-admin.event-settings.show', [
                'title' => 'Preview Event',
                'event' => $event
            ]);
        }

        // Untuk Admin: hanya boleh lihat event yang dibuat oleh dirinya
        if ($user->level_pengguna === 'Admin' && $event->user_id == $user->id) {
            return view('dashboard.super-admin.event-settings.show', [
                'title' => 'Preview Event',
                'event' => $event
            ]);
        }

        // Jika tidak memenuhi syarat, tolak akses
        abort(403, 'Anda tidak memiliki akses ke event ini.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();

        $rules = [
            'judul' => 'required',
            'deskripsi' => 'required',
            'ketua_pelaksana_id' => 'required',
            'category' => 'required',
            'tgl_pelaksanaan' => 'required',
            'foto' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'background_image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ];

        // Hanya Super Admin yang boleh memilih division_id lewat form
        if ($user->level_pengguna === 'Super Admin') {
            $rules['division_id'] = 'required';
        }

        // --- 2) Buat validator berdasarkan $rules yang sudah ada ---
        $validator = Validator::make($request->all(), $rules);

        // Prepare form input kecuali file (dipakai bila validasi gagal untuk preview)
        $formInput = $request->except(['foto', 'background_image']);

        // Handle temp file preview secara DRY
        foreach (['foto', 'background_image'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('temp');
                $formInput[$field . '_temp_path'] = $path;
            } elseif ($event->$field) {
                $formInput[$field . '_temp_path'] = $event->$field;
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan, periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        // Ambil data yang sudah tervalidasi
        $validated = $validator->validated();

        // Kalau user biasa (Admin) -> set division_id otomatis
        if ($user->level_pengguna === 'Admin') {
            $validated['division_id'] = $user->divisi_id;
        }

        // Siapkan data untuk update
        $updateData = [
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'category' => $validated['category'],
            'ketua_pelaksana_id' => $validated['ketua_pelaksana_id'],
            'division_id' => $validated['division_id'] ?? null,
            'tgl_pelaksanaan' => $validated['tgl_pelaksanaan'],
            'status' => $validated['status']
        ];

        // File handling (hapus file lama jika ada, lalu simpan yang baru)
        if ($request->hasFile('foto')) {
            if ($event->foto) {
                Storage::delete($event->foto);
            }
            $updateData['foto'] = $request->file('foto')->store('event-image');
        }

        if ($request->hasFile('background_image')) {
            if ($event->background_image) {
                Storage::delete($event->background_image);
            }
            $updateData['background_image'] = $request->file('background_image')->store('event-image');
        }

        $event->update($updateData);

        return redirect()->back()->with('success', 'Event berhasil diperbarui');
    }


    public function deleteAll()
    {
        Event::truncate();

        return redirect()->back()->with('success', 'Semua data berhasil dihapus.');
    }

    public function deleteOwnEvent()
    {
        Event::where('user_id', Auth::user()->id)->delete();

        return redirect()->back()->with('success', 'Semua Event Anda berhasil dihapus.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (!empty($event->foto) && Storage::disk('public')->exists($event->foto)) {
            Storage::disk('public')->delete($event->foto);
        }
        if (!empty($event->background_image) && Storage::disk('public')->exists($event->background_image)) {
            Storage::disk('public')->delete($event->background_image);
        }
        $event->delete();
        return redirect('/dashboard/event')->with('success', 'Event content successfully deleted!');
    }
}
