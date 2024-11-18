<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller {
    public function sendEmail(Request $request): JsonResponse {

        if (!$request->subject || $request->subject == null) {
            return response()->json([
                'message' => 'El asunto es requerido',
                'success' => false
            ]);
        }

        if (!$request->email || $request->email == null) {
            return response()->json([
                'message' => 'El correo es requerido',
                'success' => false
            ]);
        }

        if (!$request->message || $request->message == null) {
            return response()->json([
                'message' => 'El mensaje es requerido',
                'success' => false
            ]);
        }

        if (!preg_match("/^[a-zA-Z0-9.@]*$/", $request->email)) {
            return response()->json([
                'message' => 'El email no puede contener caracteres especiales',
                'success' => false
            ]);
        }

        $details = [
            'subject' => $request->subject,
            'name' => 'Minerva RV Lab',
            'email' => $request->email,
            'message' => $request->message . $request->password
        ];

        Mail::to($request->email)->send(new ContactFormMail($details));

        return response()->json([
            'message' => 'Correo enviado correctamente a: ' . $request->email,
            'success' => true
        ]);
    }
}
