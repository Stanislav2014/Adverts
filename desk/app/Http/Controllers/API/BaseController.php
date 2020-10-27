<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendResponse($data, $message)
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * error response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;

        }

        return response()->json($response, 200);
    }

}

