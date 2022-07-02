<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
// use App\Helpers\ResponseFormatter;
use Auth;

class ShortUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl) {
        $this->shortUrl = $shortUrl;
    }

    public function shortUrl(Request $request) {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'original_url' => 'required|URL',
        ]);

        if(empty($validated['name'])) {
            $validated['name'] = $validated['original_url'];
        }

        $duplicatedRandomString = 0;
        
        do {
            $validated['short_url'] = $this->randomString();
            
            $duplicatedRandomString = $this->shortUrl::whereShortUrl($validated['short_url'])->count();
        } while ($duplicatedRandomString > 0);

        $createShortUrl = $this->shortUrl::create(array_merge(
            $validated,
            ['user_id' => config('app.guest_id')]
        ));

        if ($createShortUrl) {
            return successResponse([
                'name' => $createShortUrl['name'],
                'original_url' => $createShortUrl['original_url'],
                'short_url' => $createShortUrl['short_url'],
            ]);
        }

        return errorResponse([], 'Error! Please try again later', 500);

    }

    public function customUrl(Request $request) {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'original_url' => 'required|URL',
            'short_url' => 'nullable|string',
        ]);

        if(empty($validated['name'])) {
            $validated['name'] = $validated['original_url'];
        }

        $duplicatedRandomString = 0;
        
        if (empty($validated['short_url'])) {
            do {
                $validated['short_url'] = $this->randomString();
                
                $duplicatedRandomString = $this->shortUrl::whereShortUrl($validated['short_url'])->count();
            } while ($duplicatedRandomString > 0);
        }

        $createShortUrl = $this->shortUrl::create(array_merge(
            $validated,
            ['user_id' => Auth::id()]
        ));

        if ($createShortUrl) {
            return successResponse([
                'name' => $createShortUrl['name'],
                'original_url' => $createShortUrl['original_url'],
                'short_url' => $createShortUrl['short_url'],
            ]);
        }

        return errorResponse([], 'Error! Please try again later', 500);

    }

    private function randomString() {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);
    }
}
