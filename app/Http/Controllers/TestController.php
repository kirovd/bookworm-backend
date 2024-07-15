<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function checkEnv()
    {
        $apiKey = env('NYT_API_KEY');
        Log::info('Environment Variables', [
            'NYT_API_KEY' => $apiKey,
            'APP_NAME' => env('APP_NAME'),
            'APP_ENV' => env('APP_ENV'),
        ]);

        return response()->json([
            'NYT_API_KEY' => $apiKey,
            'APP_NAME' => env('APP_NAME'),
            'APP_ENV' => env('APP_ENV'),
        ]);
    }
}
