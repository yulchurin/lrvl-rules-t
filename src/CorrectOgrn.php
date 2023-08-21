<?php

namespace MacTape\LaRules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class CorrectOgrn implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->check($value)) {
            $fail('ОГРН некорректный!');
        }
    }

    private function check(string $ogrn): bool
    {
        $ogrn = Str::remove('-', $ogrn);
        $ogrn = Str::remove(' ', $ogrn);

        $checksum = (int) Str::substr($ogrn, -1);

        $ogrn = (int) Str::substr($ogrn, 0, 12);

        return $this->getExpectedCheckSumFor($ogrn) === $checksum;
    }

    private function getExpectedCheckSumFor($calculated): int
    {
        $checksum = $calculated % 11;

        if ($calculated === 10) {
            return 0;
        }

        return $checksum;
    }
}
