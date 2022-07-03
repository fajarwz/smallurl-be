<?php

namespace Tests\Unit\Models;

use App\Models\ShortUrl;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_display_date_with_correct_format()
    {
        $now = date('Y-m-d H:i:s');
        $createVisit = Visit::factory()->create();

        $this->assertEquals($createVisit->created_at, $now);
    }

    /** @test */
    public function a_visit_has_belongs_to_short_url_relation()
    {
        $createVisit = Visit::factory()->create();

        $this->assertInstanceOf(ShortUrl::class, $createVisit->shortUrl);
        $this->assertEquals($createVisit->short_url_id, $createVisit->shortUrl->id);
    }
}
