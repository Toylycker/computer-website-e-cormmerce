<?php

namespace App\Providers;
use Illuminate\Support\Facades\Cookie;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! $this->app->isProduction());
        Paginator::useBootstrapFive();

        View::composer('app.navbar', function ($view) {
            $categories = Category::withCount(['computers'])
                ->orderBy('sort_order')
                ->orderBy('slug')
                ->get();
            $brands = Brand::withCount(['computers'])
                ->orderBy('slug')
                ->get();

            return $view->with([
                'categories' => $categories,
                'brands' => $brands,
            ]);
        });

        View::composer('app.computer', function ($view) {
            $busket = [];
            if(Cookie::has('store_comps')){
                $busket = explode(",", Cookie::get('store_comps'));
            }

            return $view->with([
                'busket' => $busket
            ]);
        });
    }
}
