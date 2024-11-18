<?php

namespace App\Rules;

use App\Models\Appointments;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TimeRangeAppointment implements ValidationRule {

    protected $date;
    protected $time;

    public function __construct($date, $time) {
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function passes($attribute, $value) {
        $startTime = new \DateTime("{$this->date} {$this->time}");
        $startTime->modify('-59 minutes');
        $endTime = new \DateTime("{$this->date} {$this->time}");
        $endTime->modify('+59 minutes');

        $existingAppointments = Appointments::where('date', $this->date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('time', [$startTime->format('H:i:s'), $endTime->format('H:i:s')]);
            })
            ->exists();

        return !$existingAppointments;
    }

    public function message() {
        return 'Ya tienes una cita registrada en el rango de una hora.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }
}
