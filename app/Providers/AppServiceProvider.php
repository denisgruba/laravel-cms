<?php

namespace App\Providers;

use App\Site;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){
			$sites = Site::join('site_user', 'sites.id', '=', 'site_user.site_id')
				->where('user_id', Auth::id())
				->get();
			$howmanysites = count($sites);
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
			view()->share('howmanysites', $howmanysites);

        });
        \Illuminate\Pagination\LengthAwarePaginator::defaultView('partials.pagination');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('League\Glide\Server', function ($app) {
            $location = new Local('../public/uploads', 0);
            $filesystem = new Filesystem($location);
            return \League\Glide\ServerFactory::create([
                'source' => $filesystem,
                'cache' => $filesystem,
                'source_path_prefix' => '',
                'cache_path_prefix' => '/.cache',
            ]);
        });
    }
}
