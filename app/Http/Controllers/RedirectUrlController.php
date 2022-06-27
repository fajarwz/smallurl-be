<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\Visit;
use Jenssegers\Agent\Agent;

class RedirectUrlController extends Controller
{
    /**
     * Redirect a given short url to the original url.
     *
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function __invoke(Request $request, $shortUrl)
    {
        $shortUrlModel = new ShortUrl;
        $agent = new Agent;
        $visit = new Visit;

        $url = $shortUrlModel::whereShortUrl($shortUrl)->get(['id', 'original_url'])->firstOrFail();

        $createVisitHistory = $visit::create([
            'short_url_id' => $url->id,
            'device' => $agent->device(),
            'browser' => $agent->browser(),
        ]);

        if($createVisitHistory) {
            return redirect()->away($url->original_url);
        }

        return abort(500);
    }
}
