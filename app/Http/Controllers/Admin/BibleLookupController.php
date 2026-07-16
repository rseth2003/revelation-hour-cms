<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BibleLookupController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'version' => ['required', 'string', 'max:30'],
            'book' => ['required', 'string', 'max:80'],
            'chapter' => ['required', 'integer', 'min:1', 'max:150'],
            'verse_start' => ['required', 'integer', 'min:1', 'max:176'],
            'verse_end' => ['nullable', 'integer', 'min:1', 'max:176'],
        ]);

        $end = $data['verse_end'] ?: $data['verse_start'];

        if ($end < $data['verse_start']) {
            return response()->json([
                'message' => 'The ending verse cannot be lower than the starting verse.',
            ], 422);
        }

        $reference = sprintf(
            '%s %d:%d%s',
            $data['book'],
            $data['chapter'],
            $data['verse_start'],
            $end > $data['verse_start'] ? '-'.$end : ''
        );

        $version = strtoupper($data['version']);

        if (in_array($version, ['KJV', 'WEB', 'ASV'], true)) {
            return $this->lookupPublicDomainVersion($reference, $version);
        }

        return $this->lookupApiBibleVersion($reference, $version);
    }

    private function lookupPublicDomainVersion(string $reference, string $version): JsonResponse
    {
        $translation = match ($version) {
            'WEB' => 'web',
            'ASV' => 'asv',
            default => 'kjv',
        };

        $response = Http::timeout(20)
            ->acceptJson()
            ->get('https://bible-api.com/'.urlencode($reference), [
                'translation' => $translation,
            ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'The Bible service could not retrieve that passage. Check the reference and your internet connection.',
            ], 422);
        }

        $json = $response->json();
        $text = trim(preg_replace('/\s+/', ' ', (string) ($json['text'] ?? '')));

        if ($text === '') {
            return response()->json([
                'message' => 'No Scripture text was returned for that reference.',
            ], 422);
        }

        return response()->json([
            'reference' => ($json['reference'] ?? $reference).' '.$version,
            'text' => $text,
            'version' => $version,
        ]);
    }

    private function lookupApiBibleVersion(string $reference, string $version): JsonResponse
    {
        $apiKey = config('services.api_bible.key');

        if (!$apiKey) {
            return response()->json([
                'message' => $version.' requires an API.Bible key and translation access. KJV, WEB and ASV work immediately without a key.',
            ], 422);
        }

        $bibles = Http::timeout(20)
            ->withHeaders(['api-key' => $apiKey])
            ->acceptJson()
            ->get('https://api.scripture.api.bible/v1/bibles', [
                'language' => 'eng',
            ]);

        if (!$bibles->successful()) {
            return response()->json([
                'message' => 'API.Bible could not verify the configured API key.',
            ], 422);
        }

        $bible = collect($bibles->json('data', []))->first(function (array $item) use ($version) {
            return strtoupper((string) ($item['abbreviation'] ?? '')) === $version
                || strtoupper((string) ($item['abbreviationLocal'] ?? '')) === $version;
        });

        if (!$bible) {
            return response()->json([
                'message' => $version.' is not licensed or enabled for this API.Bible key.',
            ], 422);
        }

        $passage = Http::timeout(20)
            ->withHeaders(['api-key' => $apiKey])
            ->acceptJson()
            ->get('https://api.scripture.api.bible/v1/bibles/'.$bible['id'].'/search', [
                'query' => $reference,
                'limit' => 10,
                'sort' => 'relevance',
            ]);

        if (!$passage->successful()) {
            return response()->json([
                'message' => 'API.Bible could not retrieve that passage.',
            ], 422);
        }

        $verses = collect($passage->json('data.verses', []));
        $text = trim(preg_replace('/\s+/', ' ', $verses->pluck('text')->implode(' ')));

        if ($text === '') {
            return response()->json([
                'message' => 'No Scripture text was returned. Confirm the book, chapter and verse.',
            ], 422);
        }

        return response()->json([
            'reference' => $reference.' '.$version,
            'text' => strip_tags($text),
            'version' => $version,
        ]);
    }
}
