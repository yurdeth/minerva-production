<?php

namespace App\Rules;

use App\Models\Appointments;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ParticipantsConflict implements ValidationRule {

    protected $participants;
    protected $start_time;
    protected $end_time;

    /**
     * @param $participants
     */
    public function __construct($participants, $start_time, $end_time) {
        $this->participants = $participants;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }

    private function passes($attribute, $value): bool {
    $timeDifference = (strtotime($this->end_time) - strtotime($this->start_time)) / 3600;

    // <- Tomando como base que lo minimo son 30 minutos de la sesión y 20 participantes (10 por sala):
    switch ($timeDifference) {
        case 1: // 40 participantes en 1 hora
            if ($this->participants > 40) {
                return false;
            }
            break;
        case 2: // 80 participantes en 2 horas
            if ($this->participants > 80) {
                return false;
            }
            break;
        case 3: // 120 participantes en 3 horas
            if ($this->participants > 120) {
                return false;
            }
            break;
        case 4: // 160 participantes in 4 horas. But: limite establecido en 150. Si hay más, la cagó. Vuelva mañana, crack.
            if ($this->participants > 150) {
                return false;
            }
            break;
        default: // Default case
            return true;
    }

    return true;
}

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!$this->passes($attribute, $value)) {
            $fail("El número de participantes excede el límite para el tiempo seleccionado");
        }
    }
}
