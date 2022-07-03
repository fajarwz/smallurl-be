<?php

namespace Tests\Unit\Requests\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Requests\Auth\RegisterRequest;
use Tests\Unit\Traits\ValidateField;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase, ValidateField;

    /** @test */
    public function name_field_is_valid()
    {
        $this->assertTrue($this->validateField('name', 'jon'));
        $this->assertTrue($this->validateField('name', 'jo'));
        $this->assertTrue($this->validateField('name', 'jon1'));
        $this->assertTrue($this->validateField('name', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet ')); //255 char
        $this->assertFalse($this->validateField('name', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet l')); //256 char
        $this->assertFalse($this->validateField('name', 'j'));
        $this->assertFalse($this->validateField('name', '1'));
        $this->assertFalse($this->validateField('name', ''));
    }

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
        $this->assertTrue($this->validateField('password', 'jonijo'));
        $this->assertTrue($this->validateField('password', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet ')); //255 char
        $this->assertFalse($this->validateField('password', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet l')); //256 char
        $this->assertFalse($this->validateField('password', 'jon1'));
        $this->assertFalse($this->validateField('password', 'j'));
        $this->assertFalse($this->validateField('password', '1'));
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

        $this->rules     = (new RegisterRequest())->rules();
        $this->validator = $this->app['validator'];
    }
}
