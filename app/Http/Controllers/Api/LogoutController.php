<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // Remove token
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

            if ($removeToken) {
                // Return response JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Logout berhasil!',
                ], 200);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Return error if token invalidation fails
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal, token tidak valid!',
            ], 500);
        }
    }
}
