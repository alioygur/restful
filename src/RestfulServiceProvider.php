<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 17:29
 */

namespace Alioygur\Restful;

use Illuminate\Support\ServiceProvider;

class RestfulServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Alioygur\Restful\Restful', function ($app) {
            return new Alioygur\Restful\Restful();
        });
    }
}