<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller implements HasMiddleware
{

    public static function middleware() 
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ]; 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Appointment::all();
    }

    public function userAppointments(Request $request) 
    {
        return $request->user()->appointments()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = $request->validate([
            'service' => 'required|string',
            'price' => 'required|integer',
            'doctor' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $request->user()->appointments()->create($field);

        return ["message" => "Appointment created successfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return  $appointment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {

        Gate::authorize('modify', $appointment);

        $field = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $appointment->update($field);

        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        Gate::authorize('modify', $appointment);

        $appointment->delete();

        return "Deleted";
    }
}
