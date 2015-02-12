<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 12.02.2015
 * Time: 15:55
 */

namespace Alioygur\Restful;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class Restful
 *
 * @package App\Support
 */
class Restful {

    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @param Collection          $collection
     * @param TransformerAbstract $callback
     *
     * @return RestfulResponse
     */
    public function collection(Collection $collection, TransformerAbstract $callback)
    {
        $resource = new FractalCollection($collection, $callback);

        $rootScope = $this->getFractal()->createData($resource);

        return $this->jsonResponse($rootScope->toArray());
    }

    /**
     * @param Model               $item
     * @param TransformerAbstract $callback
     *
     * @return RestfulResponse
     */
    public function created(Model $item, TransformerAbstract $callback)
    {
        return $this->single($item, $callback)->setStatusCode(201);
    }

    /**
     * @param Model               $item
     * @param TransformerAbstract $callback
     *
     * @return RestfulResponse
     */
    public function single(Model $item, TransformerAbstract $callback)
    {
        $resource = new Item($item, $callback);

        $rootScope = $this->getFractal()->createData($resource);

        return $this->jsonResponse($rootScope->toArray());
    }

    /**
     * @param Model               $item
     * @param TransformerAbstract $callback
     *
     * @return RestfulResponse
     */
    public function updated(Model $item, TransformerAbstract $callback)
    {
        return $this->single($item, $callback);
    }

    /**
     * @param string $message
     *
     * @return RestfulResponse
     */
    public function deleted($message = 'Success')
    {
        return $this->jsonResponse(['message' => $message], 201);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function success($message = 'Success')
    {
        return $this->jsonResponse(['message' => $message]);
    }

    /**
     * @param array  $errors
     * @param string $message
     *
     * @return RestfulResponse
     */
    public function validationFailed($errors = [], $message = 'Validation Failed')
    {
        return $this->errorResponse($message, 400, $errors);
    }

    /**
     * @param string $message
     *
     * @return RestfulResponse
     */
    public function forbidden($message = 'Forbidden')
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * @param string $message
     *
     * @return RestfulResponse
     */
    public function unauthorized($message = 'Unauthorized')
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * @param string $message
     *
     * @return RestfulResponse
     */
    public function notFound($message = 'Resource Not Found')
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * @param       $message
     * @param       $code
     * @param array $errors
     *
     * @return RestfulResponse
     */
    private function errorResponse($message, $code, $errors = [])
    {
        return $this->jsonResponse(['error' => [
            'http_code' => $code,
            'message' => $message,
            'errors' => $errors
        ]], $code);
    }

    /**
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return RestfulResponse
     */
    private function jsonResponse($data = null, $status = 200, $headers = [], $options = 0)
    {
        return new RestfulResponse($data, $status, $headers, $options);
    }

    /**
     *
     */
    public function defineMacros()
    {
        Response::macro('errorBadRequest', function($errors = [], $message = 'Bad Request', $code = 400) {
            return self::errorResponse($message, $code, $errors);
        });

        Response::macro('errorUnprocess', function($message = 'Unprocessable entity', $code = 422, $errors = []) {
            return self::errorResponse($message, $code, $errors);
        });

        Response::macro('errorUnauthorized', function($message = 'Unauthorized', $code = 401, $errors = []) {
            return self::errorResponse($message, $code, $errors);
        });

        Response::macro('errorForbidden', function($message = 'Forbidden', $code = 403, $errors = []) {
            return self::errorResponse($message, $code, $errors);
        });

        Response::macro('errorNotFound', function($message = 'Resource Not Found', $code = 404, $errors = []) {
            return self::errorResponse($message, $code, $errors);
        });
    }

    /**
     * @return Manager
     */
    public function getFractal()
    {
        if(! $this->fractal) {
            $this->setFractal(app('League\Fractal\Manager'));
        }

        return $this->fractal;
    }

    /**
     * @param Manager $fractal
     *
     * @return $this
     */
    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;

        return $this;
    }
}