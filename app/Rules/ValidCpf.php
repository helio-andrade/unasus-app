<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/\D/', '', (string) $value);

        if (! preg_match('/^\d{11}$/', $cpf)) {
            $fail('O CPF deve conter 11 digitos numericos.');

            return;
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            $fail('CPF invalido.');

            return;
        }

        $digits = array_map('intval', str_split($cpf));

        $firstDigit = $this->calculateDigit(array_slice($digits, 0, 9), 10);
        $secondDigit = $this->calculateDigit(array_slice($digits, 0, 10), 11);

        if ($digits[9] !== $firstDigit || $digits[10] !== $secondDigit) {
            $fail('CPF invalido.');
        }
    }

    /**
     * @param  array<int, int>  $digits
     */
    private function calculateDigit(array $digits, int $weight): int
    {
        $sum = 0;

        foreach ($digits as $digit) {
            $sum += $digit * $weight;
            $weight--;
        }

        $result = ($sum * 10) % 11;

        return $result === 10 ? 0 : $result;
    }
}
