<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $posts = $user->level_pengguna === 'Super Admin'
            ? Posts::with(['category', 'author'])->get()
            : Posts::with(['category', 'author'])->where('user_id', $user->id)->get();

        return view('dashboard.post-settings.index', [
            'title' => 'All Post',
            'posts' => $posts,
            'categories' => Categories::select('id', 'name')->get()
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
            'judul' => 'required',
            'category_id' => 'required',
            'slug' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'background_image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ]);

        $formInput = $request->except(['image', 'background_image']);

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp');
            $formInput['image_temp_path'] = $imagePath;
        }

        if ($request->hasFile('background_image')) {
            $bgImagePath = $request->file('background_image')->store('temp');
            $formInput['background_image_temp_path'] = $bgImagePath;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        if ($request->file('background_image')) {
            $validatedData['background_image'] = $request->file('background_image')->store('post-image');
        }

        $validatedData['user_id'] = Auth::user()->id;

        Posts::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Post Has Been Added!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Posts $post)
    {
        if (Auth::user()->level_pengguna !== 'Super Admin' && $post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melihat post ini.');
        }

        $post->load(['category', 'author']);
        return view('dashboard.post-settings.show', [
            'title' => 'Show Post',
            'post' => $post,
            'categories' => Categories::withCount('posts')->get(),
            'recentPosts' => Posts::where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(2)
                ->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {
        $rules = [
            'judul' => 'required',
            'category_id' => 'required',
            'slug' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'background_image' => 'nullable|image|file|mimes:jpeg,png,jpg|max:1000',
            'status' => 'required'
        ];

        if ($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:Posts';
        }

        $validator = Validator::make($request->all(), $rules);

        $formInput = $request->except(['image', 'background_image']);

        // Simpan sementara file gambar untuk preview jika validasi gagal
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp');
            $formInput['image_temp_path'] = $imagePath;
        } elseif ($post->image) {
            $formInput['image_temp_path'] = $post->image;
        }

        if ($request->hasFile('background_image')) {
            $bgImagePath = $request->file('background_image')->store('temp');
            $formInput['background_image_temp_path'] = $bgImagePath;
        } elseif ($post->background_image) {
            $formInput['background_image_temp_path'] = $post->background_image;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Harap periksa kembali inputan Anda!')
                ->with('form_error', true)
                ->with('form_input', $formInput);
        }

        $validatedData = $validator->validated();

        if ($request->file('image')) {
            if ($post->image != null) {
                Storage::delete($post->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-image');
        }
        if ($request->file('background_image')) {
            if ($post->background_image != null) {
                Storage::delete($post->background_image);
            }
            $validatedData['background_image'] = $request->file('background_image')->store('post-image');
        }

        Posts::where('id', $post->id)
            ->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Post Has Been Edited!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        if ($post->background_image) {
            Storage::delete($post->background_image);
        }

        Posts::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'Post Has Been Deleted!');
    }

    public function deleteAll()
    {
        Posts::truncate();

        return redirect()->back()->with('success', 'Semua data berhasil dihapus.');
    }

    public function deleteOwnPosts()
    {
        Posts::where('user_id', Auth::user()->id)->delete();

        return redirect()->back()->with('success', 'Semua post Anda berhasil dihapus.');
    }


    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Posts::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }

    public function chartDataPost()
    {
        $data = Posts::with('category')
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'category_name' => $item->category->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        return response()->json($data);
    }
}
