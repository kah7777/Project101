<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponseService
{

    /**
     * Return a successful JSON response
     *
     * @param mixed  $data The data to return in the response
     * @param string $message the success message
     * @param int $status the HTTP status Code
     *
     * @return \Illuminate\Http\JsonResponse The JSON response.
     *
     */
    public static function success($data = null, $message = 'Operation successful', $status = 200): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'message' => trans($message),
                'data' => $data,
            ],
            $status
        );
    }


    /**
     * Return an error JSON response.
     *
     * @param string $message The error message.
     * @param int $status The HTTP status code.
     * @param mixed $data The data to return in the response.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public static function error($message = 'Operation failed', $status = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => trans($message),
            'data' => $data,
        ], $status);
    }
}