<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Appointments extends Model {
    use HasFactory;

    protected $table = "appointments";
    protected $fillable = [
        "date",
        "start_time",
        "end_time",
        "number_of_assistants",
        "user_id"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function GetAppointments(){
        if (Auth::user()->roles_id == 1) {
            return DB::table('appointments')
                ->orderBy('appointments.id', 'asc')
                ->join('users', 'appointments.user_id', '=', 'users.id')
                ->join('careers', 'users.career_id', '=', 'careers.id')
                ->join('departments', 'careers.department_id', '=', 'departments.id')
                ->select(
                    'appointments.id',
                    'appointments.number_of_assistants',
                    'users.name',
                    'careers.department_id',
                    'departments.department_name',
                    'users.career_id',
                    'careers.career_name',
                    'appointments.user_id',
                    'appointments.date',
                    'appointments.start_time',
                    'appointments.end_time'
                )
                ->get();
        } else {
            $userId = Auth::id(); // Obtener el ID del usuario autenticado

            return DB::table('appointments')
                ->orderBy('appointments.id', 'asc')
                ->where('appointments.user_id', $userId)
                ->join('users', 'appointments.user_id', '=', 'users.id')
                ->join('careers', 'users.career_id', '=', 'careers.id')
                ->join('departments', 'careers.department_id', '=', 'departments.id')
                ->select([
                    'appointments.id',
                    'appointments.number_of_assistants',
                    'users.name',
                    'careers.department_id',
                    'departments.department_name',
                    'users.career_id',
                    'careers.career_name',
                    'appointments.date',
                    'appointments.start_time',
                    'appointments.end_time'
                ])
                ->get();
        }
    }

    public function GetSpecificAppointment($id){
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Obtener la cita específica
        $appointment = DB::table('appointments')->where('id', $id)->first();

        // Verificar si la cita existe
        if (!$appointment) {
            return redirect()->route('citas')->with('error', 'Cita no encontrada.');
        }

        if (Auth::user()->roles_id == 1 || $appointment->user_id == $userId) {
            // Realizar la consulta detallada si el usuario tiene permisos
            return DB::table('appointments')
                ->orderBy('appointments.id', 'asc')
                ->where('appointments.id', $id)
                ->join('users', 'appointments.user_id', '=', 'users.id')
                ->join('careers', 'users.career_id', '=', 'careers.id')
                ->join('departments', 'careers.department_id', '=', 'departments.id')
                ->select(
                    'appointments.id',
                    'appointments.number_of_assistants',
                    'users.name',
                    'careers.department_id',
                    'departments.department_name',
                    'users.career_id',
                    'careers.career_name',
                    'appointments.date',
                    'appointments.start_time',
                    'appointments.end_time'
                )
                ->get();
        } else {
            // Lanzar una excepción si el usuario no tiene permisos
            throw new \Exception("No tienes permisos para ver esta cita");
        }
    }

    /**
     * @throws \Exception
     */
    public function GetAvailableSchedules($date): Collection {
        try {
            return DB::table('appointments')
                ->where('date', $date)
                ->select('id', 'start_time', 'end_time', 'date')
                ->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
