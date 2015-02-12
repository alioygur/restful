<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 17:28
 */

namespace Alioygur\Restful\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Restful
 *
 * @package Alioygur\Restful\Facades
 */
class Restful extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'Alioygur\Restful\Restful';
    }
}