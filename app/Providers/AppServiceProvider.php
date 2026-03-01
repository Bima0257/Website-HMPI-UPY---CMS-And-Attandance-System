<?php

namespace App\Providers;

use App\Models\User;
use App\Models\About;
use App\Models\Message;
use App\Models\Posts;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }


        Model::preventLazyLoading();

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');


        $abouts = About::where('status', 'published')->first();

        $articles = Posts::with(['author', 'category'])->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();

        View::share('abouts', $abouts);
        View::share('articles', $articles);
        View::share('unreadMessages', Message::where('is_read', false)->count());

        Paginator::useBootstrapFive();

        Gate::define('super-admin', function (?User $user) {

            return $user->level_pengguna === 'Super Admin';
        });
    }
}
