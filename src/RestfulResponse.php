<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 15:05
 */

namespace Alioygur\Restful;


use Illuminate\Http\JsonResponse;

class RestfulResponse extends JsonResponse
{
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        parent::__construct($data, $status, $headers, $options);
    }

    public function mergeData(array $data)
    {
        return $this->setData(array_merge_recursive((array) $this->getData(), $data));
    }
}