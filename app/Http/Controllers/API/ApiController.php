<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendResponse($result, $message , $status)
    {
        $response = [
            'success' => $status ?? true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200, [], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code, [], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }
}
