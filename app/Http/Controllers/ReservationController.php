<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller {
    public function calculateTime(Request $request): JsonResponse {
        // Definimos las constantes de tiempo y capacidad por grupo
        $tiempoPorGrupo = 25; // minutos
        $capacidadPorGrupo = 10; // personas por grupo

        // Calculamos el número de grupos necesarios
        $gruposNecesarios = ceil($request->number_of_assistants / $capacidadPorGrupo);
        Log::info("Grupos necesarios: $gruposNecesarios");

        // El tiempo total será el número de rondas multiplicado por el tiempo por grupo
        $tiempoTotal = $gruposNecesarios * $tiempoPorGrupo;
        Log::info("Tiempo total: $tiempoTotal");

        // Obtenemos la hora de inicio
        $horaInicio = $this->getEndTimeForDay($request->date);
        Log::info('Query result: ' . json_encode($horaInicio));

        if($horaInicio == null) {
            $horaInicio = (object) ['end_time' => '08:00:00'];
        }

        if (empty($horaInicio)) {
            return response()->json([
                "message" => "No se proveyó una fecha válida",
                "success" => false,
            ]);
        }

        // hora fin = (hora inicio + 1 hora) + ceil($request->number_of_assistants / 10 participantes por sala) * 25 minutos)
        // (hora inicio + 1 hora) + ceil($request->number_of_assistants / 10 participantes por sala) * 25 minutos) = hora fin
        // ceil($request->number_of_assistants / 10 participantes por sala) * 25 minutos) = hora fin - (hora inicio + 1 hora)
        // ceil($request->number_of_assistants / 10 participantes por sala) = (hora fin - (hora inicio + 1 hora)) / 25 minutos
        // Obtener la cantidad de participantes:
        // participantes = 10 * (hora fin - (hora inicio + 1 hora)) / 25 minutos
        // No tengo idea de cómo hice esta mierda pero funciona (creo) xd

        $horaFin = date('H:i:s', strtotime($horaInicio->end_time) + 3600 + ($tiempoTotal * 60));
        $cantidadParticipantes = $request->number_of_assistants;
        if (strtotime($horaFin) > strtotime('17:00:00')) {
            $horaFin = '17:00:00';
            // No me pregunten nada de esta mierda xd
            $cantidadParticipantes = 10 * (strtotime($horaFin) - (strtotime($horaInicio->end_time) + 3600)) / 1500;
        }

        // Retornar la hora de inicio más el tiempo total para que sea la hora de fin
        return response()->json([
            // Sumar una hora a $horaInicio para que sea la hora de inicio
            "start_time" => date('H:i:s', strtotime($horaInicio->end_time) + 3600),
            "end_time" => $horaFin,
            "number_of_assistants" => $cantidadParticipantes,
            "success" => true,
        ]);
    }

    private function getEndTimeForDay($date) {
        $result = DB::table('appointments')
            ->select('end_time')
            ->where('date', $date)
            ->orderBy('end_time', 'desc')
            ->first();

        Log::info("Resultados de la consulta de end_time para la fecha $date: ", (array)$result);

        return $result;
    }
}
