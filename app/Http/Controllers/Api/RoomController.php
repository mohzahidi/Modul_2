<?php
namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return new RoomResource(true, 'List Room Data', $rooms);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|unique:rooms',
            'room_type' => 'required',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|integer',
            'status' => 'in:available,occupied,maintenance'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $room = Room::create($request->all());
        return new RoomResource(true, 'Room Added Successfully', $room);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return new RoomResource(true, 'Room Details', $room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'room_number' => 'unique:rooms,room_number,'.$id,
            'price_per_night' => 'numeric',
            'capacity' => 'integer',
            'status' => 'in:available,occupied,maintenance'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $room->update($request->all());
        return new RoomResource(true, 'Room Updated Successfully', $room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return new RoomResource(true, 'Room Deleted Successfully', null);
    }
}