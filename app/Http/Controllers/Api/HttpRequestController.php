<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
class HttpRequestController extends Controller
{
    public function index(): JsonResponse
    {
        $url = 'https://jsonplaceholder.typicode.com/users';

        $maxRetries = 3;
        $attempt    = 0;
        $response   = null;

        while ($attempt < $maxRetries) {
            $attempt++;

            $response = Http::withHeaders([
                'User-Agent' => 'LaravelHttpClient/1.0',
                'Accept'     => 'application/json',
            ])->get($url);

            if ($response->successful()) {
                break;
            }

            if ($attempt < $maxRetries) {
                sleep(1);
            }
        }

        if (!$response || $response->failed()) {
            return response()->json([
                'success'     => false,
                'status_code' => $response ? $response->status() : 0,
                'message'     => "Request failed after {$maxRetries} attempts.",
                'attempts'    => $attempt,
            ], 502);
        }

        return response()->json([
            'success'     => true,
            'status_code' => $response->status(),
            'attempts'    => $attempt,
            'data'        => $response->json(),
        ], 200);
    }
}
