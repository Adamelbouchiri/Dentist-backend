<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecondRegistrationController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'gender' => 'required|string',
        'ageRange' => 'required|string',
        'insurance' => 'required|string',
        'medication' => 'required|string',
        'medicationName' => 'nullable|string',
        'medicalHistory' => 'required|array',
        'medicalHistory.*' => 'string',
        'otherCondition' => 'nullable|string',
        'contactMethod' => 'required|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'emergencyContact' => 'required|string',
    ]);

    $secondRegistration = $request->user()->secondRegistration()->create($data);

    $user = $request->user();
    $user->update([
        'second_registration_done' => true,
    ]);

    return $secondRegistration;
}

    public function show(Request $request)
    {
        return $request->user()->secondRegistration()->first();
    }

}
