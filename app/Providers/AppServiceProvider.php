<?php

namespace App\Providers;

use App\Icon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

/**
 * Main service provider
 *
 * @category Core
 * @package  Speed
 * @author   Jordan Kniest <contact@jkniest.de>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     https://jkniest.de
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('icon', function ($expression) {
            return Icon::render($expression);
        });

        Blade::directive('iconSmall', function ($expression) {
            return Icon::render($expression, 'small');
        });

        Blade::directive('iconLarge', function ($expression) {
            return Icon::render($expression, 'large');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ..
    }
}
