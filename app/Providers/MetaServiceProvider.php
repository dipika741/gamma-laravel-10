<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MetaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Default meta values
        $defaultMeta = [
            'title' => config('app.name'),
            'description' => 'Gamma Scientific Ltd a leading supplier of high-quality pharmaceutical laboratory products and manufacturing solutions across the country',
            'keywords' => 'pharmaceutical reference standards, impurities, columns, consumables, pharmaceutical various instruments,pharmaceutical equipment',
            'canonical' => url()->current(),
            'image' => asset('images/default-og.png'),
            'type' => 'website',
        ];

        // Share with all views
        View::share('meta', $defaultMeta);
    }
}
