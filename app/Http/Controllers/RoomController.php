<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $room = Room::all();

        if ($room->isEmpty()) {
            return response()->json([
                'message' => 'No rooms found',
                'total' => 0,
            ]);
        }

        $total = Room::count();

        $data = [
            'message' => 'List of rooms',
            'rooms' => $room,
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
            'name' => 'required|unique:room',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validating data',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data);
        }

        $search = Room::where('name', $request->name)->first();

        if ($search) {
            return response()->json([
                'message' => 'Room already exists',
                'status' => 400
            ]);
        }

        $room = Room::create([
            'name' => $request->name,
            'id' => $request->id
        ]);

        if (!$room) {
            return response()->json([
                'message' => 'Error creating room',
                'status' => 500
            ]);
        }

        $data = [
            'message' => 'Room created',
            'room' => $room
        ];

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room) {
        //
    }
}
