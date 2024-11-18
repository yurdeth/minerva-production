<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Rules\AppointmentConflict;
use App\Rules\ParticipantsConflict;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Psy\Util\Json;

class AppointmentsController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $appointments = (new Appointments)->GetAppointments();
        return response()->json([
            "data" => $appointments,
            "success" => true,
        ]);
    }

    //method to generate pdf
    public function pdf() {
        $appointments = (new Appointments)->GetAppointments();
        $pdf = Pdf::loadView('appointments.citasPdf', compact('appointments'));
        return $pdf->stream();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            "number_of_assistants" => ["required", new ParticipantsConflict(
                $request->number_of_assistants,
                $request->start_time,
                $request->end_time)
            ],
            "date" => "required|date|after:today",
            "start_time" => "required",
            "end_time" => ["required", new AppointmentConflict($request,
                $request->date,
                $request->start_time,
                $request->end_time,
                'register'
            )],
        ]);

        if ($validate->fails()) {
            return response()->json([
                "message" => "Error en los datos",
                "error" => $validate->errors(),
                "success" => false,
            ]);
        }

        $appointment = Appointments::create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'number_of_assistants' => $request->number_of_assistants,
            'user_id' => Auth::id(),
        ]);

        if (!$appointment) {
            return response()->json([
                "message" => "Error al crear el registro",
                "success" => false,
            ], 500);
        }

        $appointment->save();

        if (Auth::id() == 1) {
            $redirectTo = '/dashboard/citas';
        } else {
            $redirectTo = '/citas';
        }

        return response()->json([
            "message" => "Cita registrada",
            "redirect_to" => $redirectTo,
            "success" => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        try {
            $appointments = (new Appointments)->GetSpecificAppointment($id);

            if ($appointments->isEmpty()) {
                return response()->json([
                    "message" => "Cita no encontrada",
                    "success" => false,
                ]);
            }

            return response()->json($appointments);
        } catch (Exception $e) {
            return redirect()->route('citas')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        if (!$id) {
            return response()->json([
                'message' => 'Error: no ID was provided',
                'success' => false
            ], 404);
        }

        $appointment = Appointments::find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Error: appointment not found',
                'success' => false
            ], 404);
        }

        $validate = Validator::make($request->all(), [
            "number_of_assistants" => ["required", new ParticipantsConflict(
                $request->number_of_assistants,
                $request->start_time,
                $request->end_time)
            ],
            "date" => "required|date|after:today",
            "start_time" => "required",
            "end_time" => ["required", new AppointmentConflict($request,
                $request->date,
                $request->start_time,
                $request->end_time,
                'update'
            )],
        ]);

        if ($validate->fails()) {
            return response()->json([
                "message" => "Error en los datos",
                "error" => $validate->errors(),
                "success" => false,
            ]);
        }

        $appointment = Appointments::find($id);

        $appointment->date = $request->date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->number_of_assistants = $request->number_of_assistants;

        $appointment->save();

        if (Auth::id() == 1) {
            $redirectTo = '/dashboard/citas';
        } else {
            $redirectTo = '/citas';
        }

        return response()->json([
            "message" => "Cita registrada",
            "redirect_to" => $redirectTo,
            "success" => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $appointment = Appointments::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'success' => false
            ]);
        }

        $appointment->delete();
        return redirect()->route('citas-ver');
    }

    /**
     * @throws Exception
     */
    public function AvailableSchedules(Request $request) {
        $date = $request->date;
        $schedules = (new Appointments)->GetAvailableSchedules($date);
        return response()->json($schedules);
    }

    public function getCalendarItems(): JsonResponse {
        $date = DB::select('SELECT date FROM appointments');
        $calendarItems = [];

        foreach ($date as $d) {
            $calendarItems[] = [
                "start" => $d->date,
                "display" => "background",
            ];
        }

        return response()->json([
            "data" => $calendarItems,
            "success" => true,
        ]);
    }
}
