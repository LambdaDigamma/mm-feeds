<?php

namespace LambdaDigamma\MMFeeds\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMFeeds\MMFeedsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelRay\RayServiceProvider;

class TestCase extends Orchestra
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LambdaDigamma\\MMFeeds\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MMFeedsServiceProvider::class,
            RayServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase()
    {
        $this->loadLaravelMigrations();
        include_once __DIR__.'/../database/migrations/create_mm_feeds_table.php.stub';
        (new \CreateMMFeedsTable())->up();
    }
}
