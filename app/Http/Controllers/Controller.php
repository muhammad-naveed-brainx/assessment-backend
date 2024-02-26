<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Add methods for making response object

    /**
     * @param $data
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = 'OK', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failureResponse($message, $code = 400)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
