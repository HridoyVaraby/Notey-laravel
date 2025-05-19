<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use League\CommonMark\CommonMarkConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('markdown', function ($app) {
            return new CommonMarkConverter();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('markdown', function ($expression) {
            return "<?php echo app('markdown')->convert({$expression}); ?>";
        });
    }
}