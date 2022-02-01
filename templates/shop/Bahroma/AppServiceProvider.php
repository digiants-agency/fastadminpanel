<?php

namespace App\Providers;

use App\FastAdminPanel\Helpers\Lang;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use DB;

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
        \View::composer(["inc.header","inc.footer"], function ($view) {

            $catsmenu = Cache::remember('catalogmenu', 2, function () {
            $cats = DB::table('category_'.Lang::get())
                ->select('title','slug')
                ->get();
            return $cats;
            });

			$view->with([
                'catsmenu'=>$catsmenu
			]);
		});
    }
}
