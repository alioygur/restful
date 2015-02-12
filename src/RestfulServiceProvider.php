<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 17:29
 */

namespace Alioygur\Restful;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

/**
 * Class RestfulServiceProvider
 *
 * @package Alioygur\Restful
 */
class RestfulServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Alioygur\Restful\Restful', 'Alioygur\Restful\Restful');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->defineMacros();
    }

    /**
     * Define Larave Response Macros
     *
     * @return void
     */
    private function defineMacros()
    {
        # Resources
        Response::macro('collection', function($collection, $callback) {
           return Facades\Restful::collection($collection, $callback);
        });
        Response::macro('single', function($model, $callback) {
            return Facades\Restful::single($model, $callback);
        });
        Response::macro('created', function($model, $callback) {
            return Facades\Restful::created($model, $callback);
        });
        Response::macro('updated', function($model, $callback) {
            return Facades\Restful::updated($model, $callback);
        });
        Response::macro('deleted', function($message) {
            return Facades\Restful::deleted($message);
        });
        Response::macro('success', function($message) {
            return Facades\Restful::success($message);
        });

        # Errors
        Response::macro('validationFailed', function(array $errors = [], $message = 'Validation Failed') {
            return Facades\Restful::validationFailed($errors, $message);
        });
        Response::macro('unprocessable', function($message) {
            return Facades\Restful::unprocessable($message);
        });
        Response::macro('forbidden', function($message) {
            return Facades\Restful::forbidden($message);
        });
        Response::macro('unauthorized', function($message) {
            return Facades\Restful::unauthorized($message);
        });
        Response::macro('notFound', function($message = 'Resource Not Found') {
            return Facades\Restful::notFound($message);
        });
    }
}