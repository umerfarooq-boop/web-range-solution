<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
class ExternalPostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch posts from external API.',
            ], 502);
        }

        $posts = collect($response->json());
        $search = $request->query('search');
        if ($search) {
            $posts = $posts->filter(function ($post) use ($search) {
                return str_contains(
                    strtolower($post['title']),
                    strtolower($search)
                );
            })->values();
        }

        $formatted = $posts->take(10)->map(function ($post) {
            return [
                'title' => $post['title'],
                'body'  => $post['body'],
            ];
        });

        return response()->json([
            'success' => true,
            'count'   => $formatted->count(),
            'data'    => $formatted,
        ], 200);
    }
}
