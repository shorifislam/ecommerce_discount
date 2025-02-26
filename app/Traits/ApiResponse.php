<?php

namespace App\Traits;

trait ApiResponse
{
    public function apiResponse(string $message, $data = null, bool $status = true, int $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'status' => $status
        ], $statusCode);
    }
}
