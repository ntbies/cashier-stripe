<?php

namespace Ntbies\CashierStripe\Rules;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Mpociot\VatCalculator\VatCalculator;

class VatNumberValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (!app(VatCalculator::class)->isValidVATNumber($value)) {
                $fail('The provided VAT number is invalid.');
            }
        } catch (Exception $e) {
            $fail('The provided VAT number is invalid.');
        }
    }
}

