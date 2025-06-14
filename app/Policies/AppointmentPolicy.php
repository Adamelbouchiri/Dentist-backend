<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    public function modify(User $user, Appointment $appointment): Response
    {
        return $user->id === $appointment->user_id 
        ? Response::allow() 
        : Response::deny('You do not own this appointment.');
    }
}
