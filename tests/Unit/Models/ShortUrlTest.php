<?php

namespace Tests\Unit\Models;

use App\Models\ShortUrl;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_short_url_has_belongs_to_user_relation()
    {
        $createShortUrl = ShortUrl::factory()->create();

        $this->assertInstanceOf(User::class, $createShortUrl->user);
        $this->assertEquals($createShortUrl->user_id, $createShortUrl->user->id);
    }

    /** @test */
    public function a_short_url_has_has_many_visit_relation()
    {
        $createShortUrl = ShortUrl::factory()->create();

        $recordVisit = Visit::factory()->create([
            'short_url_id' => $createShortUrl->id,
        ]);

        $shortUrl = ShortUrl::with('visits')->find($createShortUrl->id);

        $this->assertInstanceOf(Collection::class, $shortUrl->visits);
        $this->assertEquals($shortUrl->id, $shortUrl->visits->first()->short_url_id);
    }

    /** @test */
    public function it_display_date_with_correct_format()
    {
        $now = date('Y-m-d H:i:s');
        $createShortUrl = ShortUrl::factory()->create();

        $this->assertEquals($createShortUrl->created_at, $now);
        $this->assertEquals($createShortUrl->updated_at, $now);
    }
}
