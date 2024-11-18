<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyUesMail implements ValidationRule {
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!str_ends_with($value, '@ues.edu.sv') && $value != 'admin@admin.com') {
            $fail("Solo correos universitarios están permitidos");
        }
    }
}
