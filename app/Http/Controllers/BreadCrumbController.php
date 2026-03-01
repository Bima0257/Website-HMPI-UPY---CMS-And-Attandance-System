<?php

namespace App\Http\Controllers;

use App\Models\BreadCrumbBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class BreadCrumbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.super-admin.background-breadcrumb.index', [
            'title' => 'Background Settings',
            'backgrounds' => BreadCrumbBackground::all()
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
        $validator = Validator::make($request->all(), [
            'about' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'all_programs' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'program_detail' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'our_teams' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'all_articles' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'detail_article' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'category' => 'required|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        $formInput = $request->except([
            'about',
            'all_programs',
            'program_detail',
            'our_teams',
            'all_articles',
            'detail_article',
            'category'
        ]);

        // Simpan gambar sementara jika ada
        foreach (
            [
                'about',
                'all_programs',
                'program_detail',
                'our_teams',
                'all_articles',
                'detail_article',
                'category'
            ] as $field
        ) {
            if ($request->hasFile($field)) {
                $tempPath = $request->file($field)->store('temp');
                $formInput[$field . '_temp_path'] = $tempPath;
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        // Simpan gambar permanen
        foreach (
            [
                'about',
                'all_programs',
                'program_detail',
                'our_teams',
                'all_articles',
                'detail_article',
                'category'
            ] as $field
        ) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('background-image');
            }
        }

        BreadCrumbBackground::create($validatedData);

        return redirect('/dashboard/background')->with('success', 'Background Has Been Added!');
    }



    /**
     * Display the specified resource.
     */
    public function show(BreadCrumbBackground $breadCrumbBackground)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BreadCrumbBackground $background)
    {
        return response()->json($background);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BreadCrumbBackground $background)
    {
        $validator = Validator::make($request->all(), [
            'about' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'all_programs' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'program_detail' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'our_teams' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'all_articles' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'detail_article' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'category' => 'image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        $formInput = $request->except([
            'about',
            'all_programs',
            'program_detail',
            'our_teams',
            'all_articles',
            'detail_article',
            'category'
        ]);

        // Simpan sementara file gambar atau gunakan yang lama jika ada
        foreach (
            [
                'about',
                'all_programs',
                'program_detail',
                'our_teams',
                'all_articles',
                'detail_article',
                'category'
            ] as $field
        ) {
            if ($request->hasFile($field)) {
                $tempPath = $request->file($field)->store('temp');
                $formInput["{$field}_temp_path"] = $tempPath;
            } elseif ($background->$field) {
                $formInput["{$field}_temp_path"] = $background->$field;
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Periksa kembali input Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        foreach (['about', 'all_programs', 'program_detail', 'our_teams', 'all_articles', 'detail_article', 'category'] as $field) {
            if ($request->file($field)) {
                if ($background->$field != null) {
                    Storage::delete($background->$field);
                }
                $validatedData[$field] = $request->file($field)->store('background-image');
            }
        }

        $background->update($validatedData);

        return redirect('/dashboard/background')->with('success', 'Background Has Been Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BreadCrumbBackground $background)
    {
        try {
            // Daftar semua field gambar
            $imageFields = ['about', 'all_programs', 'program_detail', 'our_teams', 'all_articles', 'detail_article', 'category'];

            // Hapus semua gambar dari storage jika ada
            foreach ($imageFields as $field) {
                if ($background->$field) {
                    Storage::delete($background->$field);
                }
            }

            // Hapus data dari database
            $background->delete();

            return redirect('/dashboard/background')->with('success', 'Background Has Been Deleted!');
        } catch (\Exception $e) {
            return redirect('/dashboard/background')->with('error', 'Failed to delete background!');
        }
    }
}
