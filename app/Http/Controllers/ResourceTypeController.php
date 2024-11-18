<?php

namespace App\Http\Controllers;

use App\Models\ResourceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResourceTypeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $resourceTypes = ResourceType::all();

        if ($resourceTypes->isEmpty()) {
            return response()->json([
                'message' => 'No hay tipos de recurso registrados',
                'total' => 0
            ]);
        }

        $totalResourceTypes = ResourceType::count();
        $data = [
            'message' => 'Listado de tipos de recurso',
            'resourceTypes' => $resourceTypes,
            'total' => $totalResourceTypes
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
            'resource_name' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al validar los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data);
        }

        $resourceType = ResourceType::create([
            'resource_name' => $request->resource_name,
            'id' => $request->id
        ]);

        $data = [
            'message' => 'Tipo de recurso creado',
            'resourceType' => $resourceType
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
