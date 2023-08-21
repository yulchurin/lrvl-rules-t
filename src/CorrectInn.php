<?php

namespace MacTape\LaRules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CorrectInn implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->check($value)) {
            $fail('ИНН некорректный!');
        }
    }

    private function check(string $inn): bool
    {
        $inn = Str::remove('-', $inn);
        $inn = Str::remove(' ', $inn);

        $checksum = (int) Str::substr($inn, -1);

        return $this->getExpectedCheckSumFor($inn) === $checksum;
    }

    private function getExpectedCheckSumFor($inn): int
    {
        return ((2 * $inn[0]
            + 4 * $inn[1]
            + 10 * $inn[2]
            + 3 * $inn[3]
            + 5 * $inn[4]
            + 9 * $inn[5]
            + 4 * $inn[6]
            + 6 * $inn[7]
            + 8 * $inn[8]) % 11) % 10;
    }
}
