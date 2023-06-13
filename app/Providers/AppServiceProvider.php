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
            'title' => 'Selamat Datang di Aplikasi Pasar Depok',
            'description' => 'Sistem Pendataan Kios dan Los di Pasar Depok'
        );

        View::share($pages_data);
    }
}
