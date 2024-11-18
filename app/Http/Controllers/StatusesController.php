<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusesController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $statuses = Status::all();

        if ($statuses->isEmpty()) {
            return response()->json([
                'message' => 'No hay estados registrados',
                'total' => 0,
            ]);
        }

        $total = Status::count();
        $data = [
            'message' => 'Listado de estados',
            'statuses' => $statuses,
            'total' => $total
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data);
        }

        $status = Status::create([
            'status' => $request->status,
            'id' => $request->id
        ]);

        $data = [
            'message' => 'Estado creado',
            'status' => $status
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
