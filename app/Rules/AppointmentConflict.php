<?php

namespace App\Rules;

use App\Models\Appointments;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentConflict implements ValidationRule {

    protected $date;
    protected $startTime;
    protected $endTime;
    protected $request;
    protected $action;
    protected $message;

    public function __construct($request, string $date, string $startTime, string $endTime, string $action) {
        $this->request = $request;
        $this->date = $date;
        $this->action = $action;


        // Dividir time por ":"
        $this->startTime = count(explode(":", $startTime)) == 2 ? $startTime . ":00" : $startTime;
        $this->endTime = count(explode(":", $endTime)) == 2 ? $endTime . ":00" : $endTime;
    }

    private function passes($attribute, $value): bool {
        Log::info("###################################################################################");

        $appointments = Appointments::select('start_time', 'end_time', 'number_of_assistants')
            ->from('appointments')
            ->where('date', $this->date)
            ->get();

        $singleAppointment = Appointments::select('start_time', 'end_time', 'number_of_assistants')
            ->from('appointments')
            ->where('date', $this->date)
            ->where('id', $this->request->id)
            ->get();

        if ($this->action == 'update') {
            foreach ($singleAppointment as $s) {
                $singleStartTime = $s->start_time;
                $singleEndTime = $s->end_time;
                $singleAssistants = $s->number_of_assistants;
            }

            // No modifica nada -> no se hace nada:
            if ($this->request->start_time == $singleStartTime &&
                $this->request->end_time == $singleEndTime &&
                $this->request->number_of_assistants == $singleAssistants) {
                return true;
            }

            // Ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffuck

            if ($this->request->start_time != $singleStartTime) {
                $this->startTime = (count(explode(":", $this->request->start_time)) == 2) ?
                    $this->request->start_time . ":00" : $this->request->start_time;
                $this->endTime = (count(explode(":", $this->request->end_time)) == 2) ?
                    $this->request->end_time . ":00" : $this->request->end_time;

                // No permitir que la hora de inicio sea mayor que la final:
                if ($this->request->start_time > $singleEndTime) {
                    $this->message = "Error: horario inválido";
                    return false;
                }

                $listaRangosHorarios = [];
                foreach ($appointments as $appointment) {
                    $listaRangosHorarios[] = [
                        'start_time' => $appointment->start_time,
                        'end_time' => $appointment->end_time,
                    ];
                }

                foreach ($appointments as $appointment) {
                    // Verificar si la nueva hora de inicio coincide con alguna hora existente
                    if ($this->startTime == $appointment->start_time || $this->startTime == $appointment->end_time) {
                        $this->message = "Error: ya existe una cita en el horario seleccionado";
                        return false;
                    }

                    for ($i = 0; $i < count($listaRangosHorarios); $i++) {
                        // Verificar si el nuevo rango se superpone con las citas existentes
                        if ($this->startTime < $listaRangosHorarios[$i]['end_time'] && $this->endTime > $listaRangosHorarios[$i]['start_time']) {
                            // Aquí se permite el cambio solo si no se está moviendo a un tiempo que está dentro de un rango existente
                            if ($this->startTime < $listaRangosHorarios[$i]['start_time'] && $this->endTime <= $listaRangosHorarios[$i]['start_time']) {
                                // Este caso permite que 12 a 11 no cause conflicto
                                continue;
                            } else {
                                $this->message = "Error: ya existe una cita dentro de un rango de horario seleccionado:";
                                return false;
                            }
                        }
                    }
                }
            }

            if ($this->request->end_time != $singleEndTime){
                // No permitir que la hora de inicio sea mayor que la final (Ej.: inicia a las 9 y termina a las 8):
                if($this->request->end_time < $singleStartTime){
                    $this->message = "Error: horario inválido";
                    return false;
                }

                $listaRangosHorarios = [];

                foreach ($appointments as $appointment){
                    $listaRangosHorarios[] = [
                        'start_time' => $appointment->start_time,
                        'end_time' => $appointment->end_time,
                    ];
                }

                // Nigga, I hate this shit...
                foreach ($appointments as $appointment){
                    if($this->endTime == $appointment->end_time){
                        $this->message = "Error: ya existe una cita en el horario seleccionado (hora de fin): " . $this->endTime;
                        return false;
                    }

                    if($this->endTime == $appointment->start_time){
                        $this->message = "Error: ya existe una cita en el horario seleccionado (hora de fin): " . $this->endTime;
                        return false;
                    }

                    for ($i = 0; $i < count($listaRangosHorarios); $i++){
                        if($this->endTime > $listaRangosHorarios[$i]['start_time'] && $this->endTime < $listaRangosHorarios[$i]['end_time'] == null){
                            return true;
                        }

                        if($this->endTime > $listaRangosHorarios[$i]['start_time'] && $this->endTime < $listaRangosHorarios[$i]['end_time']){
                            $this->message = "Error: ya existe una cita en el horario seleccionado (hora de inicio): " . $this->endTime;
                            return false;
                        }
                    }
                }
            }

            return true; // No conflicts
        }

        if ($this->startTime < '08:00:00' || $this->endTime > '17:00:00' || $this->startTime >= $this->endTime) {
            $this->message = "Error: el horario de atención es de 8:00 AM a 5:00 PM";
            return false;
        }

        foreach ($appointments as $appointment) {
            // From database:
            $start = new DateTime($appointment->start_time);
            $end = new DateTime($appointment->end_time);

            // From request:
            $startRequest = new DateTime($this->startTime);
            $endRequest = new DateTime($this->endTime);

            // Calcular la diferencia en minutos
            $interval = $startRequest->diff($endRequest);
            $minutes = ($interval->h * 60) + $interval->i;

            // Maximo 72 personas
            if ($this->request->numbre_of_assistants > 72) {
                $this->message = "Error: el límite de participantes por cita es de 72 personas";
                return false;
            }

            if ($minutes < 25) {
                $this->message = "El tiempo mínimo para una cita es de 25 minutos";
                return false;
            }

            // Tiempo de espera de una hora entre citas (debe haber un margen de 1 hora entre end_time y el siguiente start_time)
            $oneHourAfterEnd = (clone $end)->modify('+1 hour');
            if ($startRequest < $oneHourAfterEnd) {
                $this->message = "Error: debe haber un margen de 1 hora entre citas";
                return false;
            }

            /* Inicio de la nueva cita dentro de una cita existente:
            $startRequest >= $start && $startRequest <= $end
            Esto verifica si el start_time de la nueva cita está entre el start_time y
            el end_time de una cita existente.

            Fin de la nueva cita dentro de una cita existente:
            $endRequest >= $start && $endRequest <= $end
            Esto verifica si el end_time de la nueva cita está entre el start_time y
            el end_time de una cita existente.

            Nueva cita abarca completamente una cita existente:
            $startRequest <= $start && $endRequest >= $end
            Esto verifica si la nueva cita comienza antes o al mismo tiempo que una cita existente y
            termina después o al mismo tiempo que la cita existente.*/

            if ($startRequest >= $start && $startRequest <= $end ||
                $endRequest >= $start && $endRequest <= $end ||
                $startRequest <= $start && $endRequest >= $end) {
                $this->message = "Error: ya existe una cita en ese horario";
                return false;
            }
        }

        return true;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message);
        }
    }
}
