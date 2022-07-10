<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_user_can_short_a_url_to_short_random_generated_string()
    {
        User::create([
            'id' => 1,
            'name' => 'Guest',
        ]);

        $data = [
            'name' => 'My Web',
            'original_url' => 'http://example.com',
        ];

        $this->post(route('short-url.short'), $data)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'meta' => [
                        'code',
                        'status',
                        'message',
                    ],
                    'data' => [
                        'name',
                        'original_url',
                        'short_url',
                    ],
                ]
            )
        ;

        $this->assertDatabaseHas('short_urls', $data);
    }

    /** @test */
    public function authenticated_user_can_short_a_url_to_short_custom_url()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $payload = [
            'name' => 'my github',
            'original_url' => 'https://github.com/fajarwz',
            'short_url' => 'fajargithub',
        ];

        $response = $this->post(route('short-url.custom'), $payload);
        $response->assertStatus(200);

        $response = $response->json();

        $this->assertEquals($response['data'], $payload);
        $this->assertDatabaseHas('short_urls', $payload);
    }
}
