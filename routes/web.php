<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminAboutController;
use App\Http\Controllers\AdminLandingPageController;
use App\Http\Controllers\BreadCrumbController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataMemberController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LaporanPresensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProkerSectionsController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UserSettingsController;
use App\Models\About;
use App\Models\DataMember;
use App\Models\Division;
use App\Models\Event;
use App\Models\Message;
use App\Models\Posts;
use App\Models\User;

Route::get('/', [AdminLandingPageController::class, 'index']);
Route::get('/teams', [AdminLandingPageController::class, 'teams']);

Route::get('/about', [AdminLandingPageController::class, 'about']);

Route::get('/workPrograms', [AdminLandingPageController::class, 'workPrograms']);
Route::get('/programDetail/{event:judul}', [AdminLandingPageController::class, 'programDetail']);
Route::get('/workPrograms/{divisi:nama_divisi}', [AdminLandingPageController::class, 'programByDivisi']);

Route::get('/posts', [AdminLandingPageController::class, 'posts']);
Route::get('/postDetail/{post:slug}', [AdminLandingPageController::class, 'postDetail']);

Route::get('/dashboard/posts/checkSlug', [PostController::class, 'checkSlug']);
Route::get('/dashboard/categories/checkSlug', [CategoryController::class, 'checkSlug']);
Route::get('/categories/posts/{category:slug}', [AdminLandingPageController::class, 'postsByCategory']);
Route::get('/posts/{author:username}', [AdminLandingPageController::class, 'show']);

Route::get('/categories', [AdminLandingPageController::class, 'categories']);

Route::get('/contact', [AdminLandingPageController::class, 'contact']);
Route::post('/contact/message', [MessageController::class, 'store'])->name('messages.store');

Route::get('/dashboard/message', [MessageController::class, 'message'])->name('messages.setting')->middleware('super-admin');

Route::get('/dashboard/messages/{id}', function ($id) {
    $message = Message::findOrFail($id);
    return response()->json([
        'name'       => $message->name,
        'email'      => $message->email,
        'asal'       => $message->asal,
        'message'    => $message->message,
        'created_at' => $message->created_at->format('d M Y - H:i'),
    ]);
});

Route::post('/dashboard/messages/{id}/read', [MessageController::class, 'markAsRead'])
    ->name('messages.read');

Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
Route::post('/messages/delete-all', [MessageController::class, 'destroyAll'])->name('messages.destroyAll');
Route::delete('/dashboard/messages/delete-selected', [MessageController::class, 'destroySelected'])
    ->name('messages.destroySelected');



Route::get('/dashboard', function () {
    $data = [
        'membersActive' => DataMember::where('status', 'Aktif')->count(),
        'membersNonActive' => DataMember::where('status', 'Tidak Aktif')->count(),
        'events' => Event::count(),
        'eventUser' => Event::where('division_id', Auth::user()->divisi_id)->count(),
        'totalArticle' => Posts::count(),
        'articlePublishedUser' => Posts::where('status', 'published')->where('user_id', Auth::user()->id)->count(),
        'articleDraftUser' => Posts::where('status', 'draft')->where('user_id', Auth::user()->id)->count(),
        'articleDraft' => Posts::where('status', 'draft')->count(),
        'articlePublished' => Posts::where('status', 'published')->count(),
        'userActive' => User::where('status', 'Aktif')->count(),
        'userNonActive' => User::where('status', 'Tidak Aktif')->count(),
        'unreadMessages' => Message::where('is_read', false)->count(),
        'allMessages' => Message::count(),
    ];

    return view('dashboard.index', [
        'title' => 'Dashboard',
        'data' => $data
    ]);
})->middleware('admin');

Route::get('/dashboard/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::delete('/dashboard/event/deleteAll', [EventController::class, 'deleteAll'])->name('events.deleteAll')->middleware('super-admin');
Route::delete('/dashboard/event/deleteOwnEvent', [EventController::class, 'deleteOwnEvent'])->name('events.deleteOwnEvent')->middleware('admin');
Route::resource('/dashboard/event', EventController::class)->middleware('admin');
Route::get('/get-members', [EventController::class, 'getMember']);

Route::get('/dashboard/posts/chart-data-post', [PostController::class, 'chartDataPost']);
Route::delete('/dashboard/posts/deleteAll', [PostController::class, 'deleteAll'])->name('posts.deleteAll')->middleware('super-admin');
Route::delete('/dashboard/posts/deleteOwnPost', [PostController::class, 'deleteOwnPosts'])->name('posts.deleteOwnPost')->middleware('admin');
Route::resource('/dashboard/posts', PostController::class)->middleware('admin');


Route::get('/dashboard/userSettings/editProfile', [UserSettingsController::class, 'editProfile'])->name('profile.edit');
Route::post('/dashboard/userSettings/updateProfile', [UserSettingsController::class, 'updateProfile'])->name('profile.update');

Route::resource('/dashboard/userSettings', UserSettingsController::class)
    ->parameters(['userSettings' => 'user'])
    ->middleware('super-admin');


// content one page
Route::resource('/dashboard/homeSections', AdminHomeController::class)->middleware('super-admin');
Route::resource('/dashboard/prokerSections', ProkerSectionsController::class)->middleware('super-admin');
Route::resource('/dashboard/about', AdminAboutController::class)->middleware('super-admin');

Route::get('/dashboard/dataMemberSection/chart-data', [DataMemberController::class, 'chartData']);
Route::resource('/dashboard/dataMemberSections', DataMemberController::class)
    ->parameters(['dataMemberSections' => 'dataMember'])
    ->middleware('admin');

Route::resource('/dashboard/categories', CategoryController::class)->middleware('super-admin');
Route::resource('/dashboard/background', BreadCrumbController::class)->middleware('super-admin');
Route::resource('/dashboard/divisions', DivisionController::class)->middleware('super-admin');


Route::resource('dashboard/qrcodes', QrCodeController::class)->except(['create', 'show', 'edit', 'update'])->middleware('super-admin');
Route::post('dashboard/qrcodes/generate-all', [QrCodeController::class, 'generateAll'])->name('qrcodes.generate-all');
Route::get('/dashboard/qrcodes/download-all', [QrCodeController::class, 'downloadAll'])->name('qrcodes.downloadAll');
Route::post('/dashboard/qrcodes/delete-all', [QrCodeController::class, 'destroyAll'])->name('qrcodes.deleteAll');


Route::resource('dashboard/presences', PresenceController::class);
Route::post('/dashboard/presences/manual', [PresenceController::class, 'storeManualPresence'])->name('presences.manual.store');
Route::post('/presences/delete-all', [PresenceController::class, 'deleteAll'])->name('presences.deleteAll');
Route::post('/presences/arsipkan', [PresenceController::class, 'arsipkanPresensi'])->name('presences.arsipkan');
Route::get('/dashboard/laporan-presensi', [LaporanPresensiController::class, 'index'])->name('laporanPresensi');
Route::get('/laporan-presensi/{tanggal}', [LaporanPresensiController::class, 'show'])->name('laporan.show');
Route::delete('/laporan-presensi/{id}', [LaporanPresensiController::class, 'destroy'])->name('laporan.destroy');
Route::delete('/laporan-presensi/tanggal/{tanggal}', [LaporanPresensiController::class, 'destroyByTanggal'])->name('laporan.destroyByTanggal');
Route::delete('dashboard/laporan-presensi/delete-all', [LaporanPresensiController::class, 'destroyAll'])->name('laporan.destroyAll');
Route::get('/laporan-presensi/export/{tanggal}', [LaporanPresensiController::class, 'exportXls'])->name('laporan.exportXls');
Route::get('/laporan-presensi/pdf/{tanggal}', [LaporanPresensiController::class, 'exportPdf'])->name('laporan.exportPdf');
