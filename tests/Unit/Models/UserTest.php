<?php

namespace Tests\Unit\Models;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_model_output_date_has_correct_format()
    {
        $now = date('Y-m-d H:i:s');
        $createUser = User::factory()->create();

        $this->assertEquals($createUser->created_at, $now);
        $this->assertEquals($createUser->updated_at, $now);
    }

    /** @test */
    public function a_user_has_has_many_short_url_relation()
    {
        $createUser = User::factory()->create();

        $createShortUrl = ShortUrl::factory()->create([
            'user_id' => $createUser->id,
        ]);

        $user = User::with('shortUrls')->find($createUser->id);

        $this->assertInstanceOf(Collection::class, $user->shortUrls);
        $this->assertEquals($user->id, $user->shortUrls->first()->user_id);
    }

    /** @test */
    public function user_model_can_generate_token()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $this->assertNotNull($token);
    }
}
