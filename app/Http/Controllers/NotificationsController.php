<?php

namespace App\Http\Controllers;

use App\Enum\ValidationTypeEnum;
use App\Models\Notifications;
use App\Rules\OnlyUesMail;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotificationsController extends Controller {
    public function index(): JsonResponse {
        // Asegúrate de que los nombres de tabla sean consistentes
        $notifications = DB::query()
            ->select('notifications.id as id', 'notifications.from as from',
                'notifications.description as description',
                'notifications.reviewed as reviewed',
                'notification_type.type as type')
            ->from('notifications')
            ->join('notification_type', 'notifications.type_id', '=', 'notification_type.id')
            ->orderBy('notifications.reviewed', 'asc')
            ->orderBy('notifications.id')
            ->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'message' => 'No hay notificaciones',
                'success' => false
            ], 404);
        }

        return response()->json([
            'notifications' => $notifications,
            'success' => true
        ]);
    }


    public function store(Request $request): JsonResponse {
        $validationService = new ValidationService($request, ValidationTypeEnum::NOTIFICATION);
        $response = $validationService->ValidateRequest();
        if ($response) {
            return response()->json($response);
        }

        $rules = [
            'from' => ['required', 'email', new OnlyUesMail()],
            'type_id' => 'required'
        ];

        if ($request->type_id == '3') {
            $rules['description'] = 'required|max:100';
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Error en los datos',
                'error' => $validate->errors(),
                'success' => false
            ], 400);
        }

        $notification = Notifications::create([
            'from' => $request->from,
            'description' => $request->description,
            'type_id' => $request->type_id,
            'reviewed' => false
        ]);

        if (!$notification) {
            return response()->json([
                'message' => 'Error al contactar con el administrador',
                'success' => false
            ], 500);
        }

        return response()->json([
            'message' => 'Mensaje enviado correctamente al administrador.',
            'success' => true
        ], 201);
    }

    public function show($id) {
        $notifications = DB::query()
            ->select('notifications.id as id', 'notifications.from as from',
                'notifications.description as description',
                'notifications.reviewed as reviewed',
                'notification_type.type as type',
                'notification_type.id as type_id')
            ->from('notifications')
            ->join('notification_type', 'notifications.type_id', '=', 'notification_type.id')
            ->where('notifications.id', $id)
            ->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'message' => 'No hay notificaciones',
                'success' => false
            ], 404);
        }

        return response()->json([
            'notifications' => $notifications,
            'success' => true
        ]);
    }

    public function update(string $id): JsonResponse {
        $notification = Notifications::find($id);

        if (!$notification) {
            return response()->json([
                'message' => 'Notificación no encontrada',
                'success' => false
            ], 404);
        }

        $notification->update([
            'reviewed' => true
        ]);

        return response()->json([
            'message' => 'Notificación marcada como revisada',
            'success' => true
        ]);
    }

    public function destroy(string $id){
        $notification = Notifications::find($id);

        if(!$notification){
            return response()->json([
                'message' => 'Notificación no encontrada',
                'success' => false
            ]);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notificación eliminada',
            'success' => true
        ]);
    }

    public function countNotifications(): JsonResponse {
        $notificationCount = Notifications::where('reviewed', false)->count();
        return response()->json(['count' => $notificationCount]);
    }

}
