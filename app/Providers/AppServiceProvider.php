<?php
namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use View;

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
       // Share categories with all views
    View::composer('*', function ($view) {
        $view->with('headerCategories', Category::with('subcategories')->get());
    });
    }
}
