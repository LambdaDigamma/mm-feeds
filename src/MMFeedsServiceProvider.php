<?php

namespace LambdaDigamma\MMFeeds;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LambdaDigamma\MMFeeds\Commands\MMFeedsCommand;
use LambdaDigamma\MMFeeds\Models\Feed;
use LambdaDigamma\MMFeeds\Models\Post;

class MMFeedsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/mm-feeds.php' => config_path('mm-feeds.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mm-feeds'),
            ], 'views');

            $migrationFileName = 'create_mm_feeds_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                MMFeedsCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mm-feeds');
        $this->registerRoutes();
    }

    public function register()
    {
        $this->app->register('LaravelArchivable\LaravelArchivableServiceProvider');

        $this->mergeConfigFrom(__DIR__ . '/../config/mm-feeds.php', 'mm-feeds');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

    protected function registerRoutes()
    {
        Route::bind('anyfeed', function ($id) {
            return Feed::query()
                 ->withTrashed()
                 ->findOrFail($id);
        });

        Route::bind('anypost', function ($id) {
            return Post::query()
                ->withTrashed()
                ->withArchived()
                ->findOrFail($id);
        });

        Route::group($this->apiRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        Route::group($this->adminRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        });
    }

    protected function apiRouteConfiguration()
    {
        return [
            'prefix' => config('mm-feeds.api_prefix', 'api'),
            'middleware' => config('mm-feeds.api_middleware', ['api']),
            'as' => 'api.',
        ];
    }

    protected function adminRouteConfiguration()
    {
        return [
            'prefix' => config('mm-feeds.admin_prefix', 'admin'),
            'middleware' => config('mm-feeds.admin_middleware', ['web', 'auth']),
            'as' => 'admin.',
        ];
    }
}
