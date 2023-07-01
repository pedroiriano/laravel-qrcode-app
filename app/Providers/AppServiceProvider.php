<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $all_users = User::paginate(3);

        $pages_data = array(
            'all_users' => $all_users,
            'title' => 'Selamat Datang di SIDONNA',
            'description' => 'Sistem Data Online Pedagang di UPTD Pasar Kemirimuka Kota Depok'
        );

        View::share($pages_data);
    }
}
