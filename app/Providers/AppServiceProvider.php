<?php

namespace App\Providers;

use App\Infra\Interfaces\PageSpeedServiceInterface;
use App\Services\Google\PageSpeedOnline\PageSpeedOnlineService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PageSpeedServiceInterface::class, function (Application $app) {
            return new PageSpeedOnlineService($app['config']['google.PAGE_SPEED_ONLINE.API_KEY']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('styledLink', function (string $expression) {
            return "<?php \App\Helpers\Blade\BladeHelper::styledLink(".$expression."); ?>";
        });

        Blade::directive('isRoute', function (string $expression) {
            $split = explode(',', $expression);
            return "<?php if (Route::is($split[0])) echo $split[1]; ?>";
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            PageSpeedServiceInterface::class,
        ];
    }
}
