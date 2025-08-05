<?php

namespace App\Helpers;

class BaseResponse
{
    public static function success($data = [], $message = 'Success!', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Something went wrong!', $errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    public static function validationError($errors = [], $message = 'Validation Error!')
    {
        return self::error($message, $errors, 422);
    }

    public static function unauthorized($message = 'Unauthorized!')
    {
        return self::error($message, [], 401);
    }
}
