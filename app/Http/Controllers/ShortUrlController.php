<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Http\Requests\ShortUrl\StoreRequest;
use App\Http\Requests\ShortUrl\CustomUrlRequest;
use Auth;

class ShortUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl) {
        $this->shortUrl = $shortUrl;
    }

    public function store(StoreRequest $request) {
        $createShortUrl = $this->shortUrl::create(array_merge(
            $request->validated(),
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

    public function customUrl(CustomUrlRequest $request) {
        $createShortUrl = $this->shortUrl::create(array_merge(
            $request->validated(),
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

}
