<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Fetches live Google Places rating + review count for a given Place ID.
 * Results are cached for 1 hour to avoid hammering the API quota.
 * Fails gracefully: returns null on network/API errors so the template
 * can show a fallback state instead of crashing.
 */
class GooglePlacesService
{
    // Cache TTL: 1 hour — good balance between freshness and API quota
    private const CACHE_TTL = 3600;
    private const API_URL   = 'https://maps.googleapis.com/maps/api/place/details/json';

    private FilesystemAdapter $cache;

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey
    ) {
        $this->cache = new FilesystemAdapter('google_places', self::CACHE_TTL);
    }

    /**
     * Returns ['rating' => float, 'user_ratings_total' => int, 'name' => string]
     * or null on failure.
     */
    public function getPlaceDetails(string $placeId): ?array
    {
        if (!$this->apiKey || $this->apiKey === 'your_google_places_api_key_here') {
            return null;
        }

        $cacheKey = 'place_' . md5($placeId);

        try {
            return $this->cache->get($cacheKey, function (ItemInterface $item) use ($placeId) {
                $item->expiresAfter(self::CACHE_TTL);

                $response = $this->httpClient->request('GET', self::API_URL, [
                    'query' => [
                        'place_id' => $placeId,
                        'fields'   => 'name,rating,user_ratings_total',
                        'key'      => $this->apiKey,
                        'language' => 'fr',
                    ],
                    'timeout' => 5,
                ]);

                $data = $response->toArray();

                if (($data['status'] ?? '') !== 'OK') {
                    // Return null so we fall back gracefully — don't cache failures
                    $item->expiresAfter(60); // short TTL for errors
                    return null;
                }

                return [
                    'rating'              => $data['result']['rating'] ?? null,
                    'user_ratings_total'  => $data['result']['user_ratings_total'] ?? null,
                    'name'                => $data['result']['name'] ?? null,
                ];
            });
        } catch (\Throwable $e) {
            // Never crash the page because of a Google API issue
            return null;
        }
    }
}
