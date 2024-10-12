<?php

namespace App\Listeners;
;
use App\Services\AppointmentService;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScheduleVaccineAppointment
{
    protected $appointmentService;

    /**
     * Create the event listener.
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        $selected_center = $user->vaccineCenter;
        $appointment = $this->appointmentService->scheduleAppointment($user, $selected_center);

        SendWelcomeEmailJob::dispatch($user, $appointment);
    }
}
