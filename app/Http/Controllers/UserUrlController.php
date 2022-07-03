<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\Visit;

class UserUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl, Visit $visit) {
        $this->shortUrl = $shortUrl;
        $this->visit = $visit;
    }

    public function index() {
        return successResponse($this->shortUrl::whereUserId(auth()->id())->get());
    }

    public function visit($shortUrlId) {
        $url = $this->shortUrl::with('visits')->find($shortUrlId);

        if($url->user_id === auth()->id()) 
            return successResponse($url);

        return errorResponse([], 'Not found', 404);
    }
}
