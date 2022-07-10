<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RedirectUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function visitor_redirected_to_original_url_when_visiting_the_short_url_and_recorded_as_a_visit()
    {
        $shortUrl = ShortUrl::factory()->create([
            'original_url' => 'https://github.com/fajarwz',
            'short_url' => 'fajargithub',
        ]);

        $this->get(route('redirect-url.invoke', $shortUrl->short_url))
            ->assertStatus(302)
            ->assertLocation($shortUrl->original_url);

        $visits = Visit::find($shortUrl->id)->get();

        $this->assertInstanceOf(Collection::class, $visits);

    }

}
