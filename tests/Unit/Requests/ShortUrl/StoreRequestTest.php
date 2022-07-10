<?php

namespace Tests\Feature\Requests\ShortUrl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\Traits\ValidateField;
use App\Http\Requests\ShortUrl\StoreRequest;

class StoreRequestTest extends TestCase
{
    use ValidateField;

    /** @test */
    public function name_field_is_valid()
    {
        $this->assertTrue($this->validateField('name', 'jon'));
        $this->assertTrue($this->validateField('name', 'jo'));
        $this->assertTrue($this->validateField('name', 'j'));
        $this->assertTrue($this->validateField('name', 'jon1'));
        $this->assertTrue($this->validateField('name', '1'));
        $this->assertTrue($this->validateField('name', ''));
        $this->assertTrue($this->validateField('name', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur l')); //191 char
        $this->assertFalse($this->validateField('name', 'lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lorem ipsum dolor sit amet contecstur lo')); //192 char
    }

    /** @test */
    public function original_url_field_is_valid()
    {
        $this->assertTrue($this->validateField('original_url', 'http://example.com'));
        $this->assertTrue($this->validateField('original_url', 'https://example.com'));
        $this->assertTrue($this->validateField('original_url', 'http://www.example.com'));
        $this->assertTrue($this->validateField('original_url', 'https://www.example.com'));
        $this->assertTrue($this->validateField('original_url', 'http://id.sub.example.com'));
        $this->assertTrue($this->validateField('original_url', 'https://id.sub.example.com'));
        $this->assertTrue($this->validateField('original_url', 'example.com'));
        $this->assertFalse($this->validateField('original_url', 'example'));
        $this->assertFalse($this->validateField('original_url', 'example com'));
        $this->assertFalse($this->validateField('original_url', ''));
    }

    /**
     * Set up operations
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new StoreRequest())->rules();
        $this->validator = $this->app['validator'];
    }
}
