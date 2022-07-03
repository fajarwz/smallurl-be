<?php

namespace Tests\Unit\Traits;

trait ValidateField {
    /**
     * Check a field and value against validation rule
     * 
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    protected function validateField(string $field, $value): bool
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        )->passes();
    }
}