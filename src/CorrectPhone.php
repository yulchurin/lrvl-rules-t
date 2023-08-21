<?php

namespace App\Rules;

use Closure;
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;
use Illuminate\Contracts\Validation\ValidationRule;

class CorrectPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $number = null;

        try {
            $number = PhoneNumber::parse($value);
        } catch (PhoneNumberParseException $e) {
            $fail('Номер телефона введён не верно');
        }

        if (! $number?->isValidNumber()) {
            $fail('Номер телефона не корректный');
        }
    }
}
