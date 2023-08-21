<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CorrectSnils implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->check($value)) {
            $fail('СНИЛС некорректный!');
        }
    }

    private function check(string $snils): bool
    {
        $snils = Str::remove('-', $snils);
        $snils = Str::remove(' ', $snils);
        $checksum = (int) Str::substr($snils, -2);
        $snils = Str::substr($snils, 0, 9);
        $snils = Str::reverse($snils);

        $snilsDigitsArray = array_map('intval', str_split($snils));

        $checksumCalculated = 0;

        for ($multiplier = 1; $multiplier < 10; $multiplier++) {
            $checksumCalculated += $snilsDigitsArray[$multiplier - 1] * $multiplier;
        }

        return $this->getExpected($checksumCalculated) === $checksum;
    }

    private function getExpected($calculated): int
    {
        if ($calculated < 100) {
            return $calculated;
        }

        if ($calculated === 100 || $calculated === 101) {
            return 0;
        }

        return $this->getExpected($calculated % 101);
    }
}
