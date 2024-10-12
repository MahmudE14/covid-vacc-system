<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AppointmentService;

class VaccineAppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function schedule(Request $request)
    {
        // Fetch the user (e.g., from the request or authenticated user)
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $appointment = $this->appointmentService->scheduleAppointment($user);

        if (!$appointment) {
            return response()->json(['error' => 'No available slots or centers'], 422);
        }

        return response()->json([
            'message' => 'Appointment scheduled successfully',
            'appointment' => $appointment,
        ]);
    }
}
