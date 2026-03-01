<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\BreadCrumbBackground;
use App\Models\Categories;
use App\Models\DataMember;
use App\Models\Division;
use App\Models\Event;
use App\Models\HomeSection;
use App\Models\Posts;
use App\Models\ProkerSections;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminLandingPageController extends Controller
{
    public function index()
    {
        // Cache selama 10 menit (600 detik)
        $members = Cache::remember('members_home', 600, function () {
            return DataMember::with('division')
                ->where('status', 'Aktif')
                ->limit(8)
                ->get();
        });

        $carousels = Cache::remember('carousels_home', 600, function () {
            return HomeSection::where('status', 'published')->get();
        });

        $proker = Cache::remember('proker_home', 600, function () {
            return ProkerSections::where('status', 'published')->first();
        });

        $events = Cache::remember('events_home', 600, function () {
            return Event::with('divisi')
                ->whereIn('status', ['ongoing', 'completed'])
                ->whereIn('category', ['Big Event', 'Normal Event'])
                ->orderByRaw("CASE WHEN category = 'Big Event' THEN 1 ELSE 2 END")
                ->get();
        });

        $abouts = Cache::remember('abouts_home', 600, function () {
            return About::where('status', 'published')->first();
        });

        return view('Landingpage.index', [
            'title' => 'Home',
            'carousels' => $carousels,
            'proker' => $proker,
            'events' => $events,
            'abouts' => $abouts,
            'members' => $members
        ]);
    }

    public function teams()
    {
        $teams = DataMember::with('division')
            ->select('id', 'division_id', 'link_ig', 'nama', 'foto', 'jabatan')
            ->filter(request()->only(['search', 'divisi']))
            ->get()
            ->groupBy(fn($team) => $team->division->nama_divisi ?? 'Tanpa Divisi')
            ->sortKeys(); // optional: urut alfabet

        return view('Landingpage.teams.index', [
            'title' => 'Our Team',
            'teams' => $teams,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')
                ->select('our_teams')
                ->first()
        ]);
    }




    public function workPrograms()
    {
        $events = Event::with('divisi')
            ->filter(request()->only(['search']))
            ->get()
            ->sortBy(fn($event) => $event->divisi->nama_divisi === 'KETUA & WAKIL' ? 0 : 1)
            ->groupBy(fn($event) => $event->divisi->nama_divisi ?? 'Tanpa Divisi');

        return view('Landingpage.work-programs.index', [
            'title' => 'Work Programs',
            'events' => $events,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('all_programs')->first()
        ]);
    }



    public function programDetail(Event $event)
    {
        return view('Landingpage.work-programs.program-detail', [
            'title' => $event->judul,
            'detail' => $event,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')
                ->select('program_detail')
                ->first(),
        ]);
    }


    public function programByDivisi(Division $divisi)
    {
        $events = Event::with('divisi')
            ->where('division_id', $divisi->id)
            ->get()
            ->groupBy(fn($event) => $event->divisi->nama_divisi ?? 'Tanpa Divisi');

        return view('Landingpage.work-programs.index', [
            'title' => 'Program - ' . $divisi->nama_divisi,
            'events' => $events,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('all_programs')->first()
        ]);
    }



    public function posts()
    {
        $post = Posts::with('author', 'category')
            ->where('status', 'published')
            ->filter(request()->only(['search', 'category', 'author']))
            ->paginate(6);

        return view('Landingpage.posts.index', [
            'title' => 'Article And News',
            'posts' => $post,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('all_articles')->first()
        ]);
    }


    public function postDetail(Posts $post)
    {
        if ($post->status !== 'published') {
            abort(404, 'Post not found');
        }
        $post->load(['category', 'author']);
        return view('Landingpage.posts.detailPost', [
            'title' => 'Article and News',
            'post' => $post,
            'categories' => Categories::withCount('posts')->get(),
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('detail_article')->first(),
            'recentPosts' => Posts::where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
        ]);
    }


    public function categories()
    {
        return view('Landingpage.posts.categories', [
            'title' => 'Article dan News',
            'categories' => Categories::where('status', 'aktif')->paginate(5),
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('category')->first()
        ]);
    }

    public function postsByCategory(Categories $category)
    {
        $posts = Posts::with('author', 'category')
            ->where('category_id', $category->id)
            ->paginate(3);

        return view('Landingpage.posts.index', [
            'posts' => $posts,
            'title' => 'Category: ' . $category->name,
            'category' => $category,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('category')->first()
        ]);
    }

    public function show(User $author)
    {
        $posts = Posts::with('author', 'category')
            ->where('user_id', $author->id)
            ->paginate(6);

        return view('Landingpage.posts.index', [
            'title' => 'Author-' . $author->name,
            'posts' => $posts,
            'author' => $author,
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('detail_article')->first()
        ]);
    }

    public function about()
    {
        return view('Landingpage.about.index', [
            'title' => 'About Hmpi',
            'abouts' => About::where('status', 'published')->first(),
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('about')->first()
        ]);
    }

    public function contact()
    {
        return view('Landingpage.contact.index', [
            'title' => 'Contact Us',
            'abouts' => About::where('status', 'published')->first(),
            'backgrounds' => BreadCrumbBackground::where('status', 'published')->select('about')->first()
        ]);
    }
}
