<?php

namespace N7olkachev\RouteHelpers\Test;

use N7olkachev\RouteHelpers\RouteHelpersServiceProvider;
use Orchestra\Testbench\TestCase;

class RouteHelpersTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        \Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {
            \Route::get('/')->name('home');
            \Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
                \Route::get('/{user}')->name('show');
            });
        });
    }

    protected function getPackageProviders($app)
    {
        return [RouteHelpersServiceProvider::class];
    }

    /** @test */
    public function it_works()
    {
        $cachePath = __DIR__ . '/build/cache.php';
        config(['route-helpers.path' => $cachePath]);

        \Artisan::call('route:helpers');

        include $cachePath;

        $this->assertEquals(route('admin.home'), admin_home_url());
        $this->assertEquals(route('admin.users.show', ['user' => 5]), admin_users_show_url(['user' => 5]));
    }
}
