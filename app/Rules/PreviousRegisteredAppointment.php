<?php

namespace App\Rules;

use App\Models\Appointments;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class PreviousRegisteredAppointment implements ValidationRule {
    protected $date;
    protected $time;

    public function __construct($date, $time) {
        $this->date = $date;
        $this->time = $time . ":00";
    }

    public function passes($attribute, $value): bool {
        $appointmentExists = Appointments::where('date', $this->date)
            ->where('time', $this->time)
            ->exists();

        return !$appointmentExists;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!$this->passes($attribute, $value)) {
            $fail("Ya tienes una cita registrada en esta fecha y hora");
        }
    }
}
