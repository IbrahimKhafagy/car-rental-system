<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    public static function success(array $data = [], string $message = '', int $status = 200)
    {
        return response()->json(['success' => true,'message' => $message,'data' => $data,], $status);
    }


    public static function error(string $message, int $status = 400, string $error = null)
    {
        return response()->json(['success' => false,'message' => $message,'error' => $error,], $status);
    }
}
