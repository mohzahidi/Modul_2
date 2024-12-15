<?php
namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::latest()->paginate(10);
        return new ReservationResource(true, 'List Reservation Data', $reservations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required|numeric',
            'status' => 'in:confirmed,checked_in,checked_out,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reservation = Reservation::create($request->all());
        return new ReservationResource(true, 'Reservation Created Successfully', $reservation);
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return new ReservationResource(true, 'Reservation Details', $reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'room_id' => 'exists:rooms,id',
            'guest_email' => 'email',
            'check_out_date' => 'date|after:check_in_date',
            'total_price' => 'numeric',
            'status' => 'in:confirmed,checked_in,checked_out,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reservation->update($request->all());
        return new ReservationResource(true, 'Reservation Updated Successfully', $reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return new ReservationResource(true, 'Reservation Deleted Successfully', null);
    }
}