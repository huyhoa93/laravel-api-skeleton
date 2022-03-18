<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function responseSuccess($data, $statusCode = 200)
    {
        return response()->json(['data' => $data], $statusCode);
    }

    public function responseError($message, $statusCode)
    {
        return response()->json(['message' => $message], $statusCode);
    }
}
