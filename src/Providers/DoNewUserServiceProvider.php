<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/9/28
 * Time: 11:16
 */

namespace Fangxu\Donews\Providers;

use Fangxu\Donews\Contracts\DoNewsLoginUser;
use Fangxu\Donews\Contracts\DoNewsUser;
use Fangxu\Donews\Services\DoNewsUserService;
use \Illuminate\Support\ServiceProvider;

class DoNewUserServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DoNewsUser::class, function ($app) {
            return new DoNewsUserService(false);
        });

        $this->app->singleton(DoNewsLoginUser::class, function ($app) {
            return new DoNewsUserService(true);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [DoNewsUserService::class];
    }

}