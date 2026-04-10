<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScraperController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $baseUrl = 'http://quotes.toscrape.com';
        $totalPages = max(1, (int) $request->query('pages', 1));

        $allQuotes = [];

        for ($page = 1; $page <= $totalPages; $page++) {
            $url = $page === 1 ? $baseUrl : "$baseUrl/page/$page/";
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; LaravelScraper/1.0)',
            ])->get($url);
            if ($response->failed()) {
                break;
            }

            $html = $response->body();

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            $xpath = new \DOMXPath($dom);

            $quoteNodes = $xpath->query("//div[@class='quote']");
            if ($quoteNodes->length === 0) {
                break;
            }

            foreach ($quoteNodes as $node) {
                $textNode  = $xpath->query(".//span[@class='text']", $node)->item(0);
                $authorNode = $xpath->query(".//small[@class='author']", $node)->item(0);

                $text   = $textNode  ? trim($textNode->textContent)  : 'N/A';
                $author = $authorNode ? trim($authorNode->textContent) : 'Unknown';

                $allQuotes[] = [
                    'quote'  => $text,
                    'author' => $author,
                    'page'   => $page,
                ];
            }
        }

        return response()->json([
            'success'      => true,
            'pages_scraped' => $totalPages,
            'total_quotes' => count($allQuotes),
            'data'         => $allQuotes,
        ], 200);
    }
}
