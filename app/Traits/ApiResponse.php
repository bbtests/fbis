<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
 */

trait ApiResponse
{
    /**
     * Return a success, failed, error response.
     *
     * @param  array $data
     * @param  string $message
     * @param  int $code
     * @return array
     */
    protected function success($data = [], string $message = "", int $code = Response::HTTP_OK)
    {
        return $this->res('SUCCESS', $message, $data, $code);
    }
    protected function failed($data = [], string $message = "", int $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return $this->res('FAILED', $message, $data, $code);
    }

    protected function error($data = [], string $message = "", int $code = Response::HTTP_BAD_REQUEST)
    {
        return $this->res('ERROR', $message, $data, $code);
    }

    protected function res(string $type, string $message, array $data, int $code): array
    {
        return [
            'status' => $type,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ];
    }
}
