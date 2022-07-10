<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_logout()
    {
        $data = [
            'name' => 'John',
            'email' => 'john@test.com',
            'password' => bcrypt('password'),
        ];

        User::factory()->create($data);
        $this->assertDatabaseHas('users', $data);

        $this->post(route('auth.login'), array_merge($data, [
            'password' => 'password',
        ]))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    "meta" => [
                        "code",
                        "status",
                        "message",
                    ],
                    "data" => [
                        "user" => [
                            "name",
                            "email",
                            "updated_at",
                            "created_at",
                            "id",
                        ],
                        "access_token" => [
                            "token",
                            "type",
                            "expires_in",
                        ]
                    ]
                ]
            )
            ;
        
        $this->post(route('auth.logout'))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    "meta" => [
                        "code",
                        "status",
                        "message",
                    ],
                    "data" => []
                ]
            )
            ;
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $data = [
            'name' => 'John',
            'email' => 'john@test.com',
            'password' => 'password',
        ];

        $response = $this->post(route('auth.login'), $data);
        $response->assertStatus(401);

        $responseJson = $response->json();

        $this->assertEquals($responseJson['meta']['message'], 'Incorrect username or password!');
    }

    /** @test */
    public function unauthenticated_users_receive_unauthenticated_response_while_accessing_protected_route()
    {
        $response = $this->get(route('user-url.index'));
        $response->assertStatus(401);

        $responseJson = $response->json();

        $this->assertEquals($responseJson['meta']['message'], 'Unauthenticated.');
    }
}
