<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helpers\ResponseFormatter;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function api_response_function_is_exists()
    {
        $this->assertTrue(function_exists('apiResponse'), 'The apiResponse() function does not exists.');
    }

    /** @test */
    public function success_response_function_is_exists()
    {
        $this->assertTrue(function_exists('successResponse'), 'The successResponse() function does not exists.');
    }

    /** @test */
    public function error_response_function_is_exists()
    {
        $this->assertTrue(function_exists('errorResponse'), 'The errorResponse() function does not exists.');
    }

    /** @test */
    public function an_api_response_helper_has_meta_and_data_key()
    {
        $response = apiResponse();

        $this->assertIsArray($response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('code', $response['meta']);
        $this->assertArrayHasKey('status', $response['meta']);
        $this->assertArrayHasKey('message', $response['meta']);
        
        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function a_success_response_helper_return_value_is_json()
    {
        $response = successResponse();

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }

    /** @test */
    public function a_success_response_helper_default_code_is_200()
    {
        $response = successResponse()->original;

        $this->assertEquals(200, $response['meta']['code']);
    }

    /** @test */
    public function a_success_response_helper_default_status_is_success()
    {
        $response = successResponse()->original;

        $this->assertEquals('success', $response['meta']['status']);
    }

    /** @test */
    public function an_error_response_helper_default_code_is_400()
    {
        $response = errorResponse()->original;

        $this->assertEquals(400, $response['meta']['code']);
    }

    /** @test */
    public function an_error_response_helper_default_status_is_error()
    {
        $response = errorResponse()->original;

        $this->assertEquals('error', $response['meta']['status']);
    }

}
