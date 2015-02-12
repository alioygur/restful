<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 15:05
 */

namespace Alioygur\Restful;


use Illuminate\Http\JsonResponse;

/**
 * Class RestfulResponse
 *
 * @package Alioygur\Restful
 */
class RestfulResponse extends JsonResponse
{
    /**
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     */
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        parent::__construct($data, $status, $headers, $options);
    }

    /**
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function mergeData(array $data)
    {
        return $this->setData(array_merge_recursive((array) $this->getData(), $data));
    }
}