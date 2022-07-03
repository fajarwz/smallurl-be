<?php

namespace Tests\Unit\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\Traits\ValidateField;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase, ValidateField;

    /** @test */
    public function email_field_is_valid()
    {
        $this->assertTrue($this->validateField('email', 'jon@gmail.com'));
        $this->assertTrue($this->validateField('email', 'j@gmail.com'));
        $this->assertFalse($this->validateField('email', 'jon'));
        $this->assertFalse($this->validateField('email', 'jon@gmail'));
    }

    /** @test */
    public function password_field_is_valid()
    {
        $this->assertTrue($this->validateField('password', 'jonijoni'));
        $this->assertFalse($this->validateField('password', ''));
    }

    /**
     * Set up operations
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new LoginRequest())->rules();
        $this->validator = $this->app['validator'];
    }
}
