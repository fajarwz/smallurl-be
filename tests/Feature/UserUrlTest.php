<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_their_urls()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $shortUrl = ShortUrl::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('user-url.index'));
        $response->assertStatus(200);

        $responseJson = $response->json();

        $this->assertEquals($responseJson['data'][0]['original_url'], $shortUrl->original_url);
        $this->assertEquals($responseJson['data'][0]['short_url'], $shortUrl->short_url);
    }

    /** @test */
    public function user_can_get_their_url_visits()
    {
        $user = User::factory()->create(['id' => 2]);
        $token = auth()->login($user);

        $shortUrl = ShortUrl::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'original_url' => 'https://github.com/fajarwz',
            'short_url' => 'fajargithub',
        ]);

        $this->get(route('redirect-url.invoke', $shortUrl->short_url));

        $response = $this->get(route('user-url.visit', $shortUrl->id));
        $response->assertStatus(200);

        $responseJson = $response->json();
        $this->assertIsArray($responseJson['data']['visits']);

    }
}
