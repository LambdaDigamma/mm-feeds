<?php

namespace LambdaDigamma\MMFeeds;

use Illuminate\Support\ServiceProvider;
use LambdaDigamma\MMFeeds\Commands\MMFeedsCommand;

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
    }

    public function register()
    {
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
}
