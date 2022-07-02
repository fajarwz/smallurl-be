<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helpers\ResponseFormatter;

class ResponseFormatterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_success_response_formatter_has_meta_properties()
    {
        $response = ResponseFormatter::success([]);

        // dd($response);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $response->assertExactJson('meta');

        // $response = $this->postJson('/api/v1/short-url', ['original_url' => 'https://example.com']);

        // $response->assertStatus(200)
        //     ->assertJson([
        //         'meta' => [
        //             'code' => 200,
        //             'status' => 'success',
        //             'message' => null,
        //         ],
        //     ]);

        // $this->assertTrue(true);
    }
}
