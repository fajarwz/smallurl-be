<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\Visit;
use App\Helpers\ResponseFormatter;

class UserUrlController extends Controller
{
    public function __construct(ShortUrl $shortUrl, Visit $visit) {
        $this->shortUrl = $shortUrl;
        $this->visit = $visit;
    }

    public function index() {
        return ResponseFormatter::success($this->shortUrl::whereUserId(auth()->id())->get());
    }

    public function visit($shortUrlId) {
        $url = $this->shortUrl::with('visits')->find($shortUrlId);

        if($url->user_id === auth()->id()) 
            return ResponseFormatter::success($url);

        return ResponseFormatter::error([], 'Not found', 404);
    }
}
