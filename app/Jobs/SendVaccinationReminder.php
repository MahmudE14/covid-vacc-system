<?php

namespace App\Jobs;

use App\Mail\VaccinationReminderMail;
use App\Models\VaccineAppointment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendVaccinationReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date_tomorrow = now()->addDay()->format('Y-m-d');

        $tomorrow_appointments = VaccineAppointment::where('scheduled_date', $date_tomorrow)->get();

        \Illuminate\Support\Facades\Log::info(
            json_encode([
                'tomorrow_appointments' => $tomorrow_appointments->count(),
            ])
        );

        foreach ($tomorrow_appointments as $appointment) {
            Mail::to($appointment->user->email)->send(new VaccinationReminderMail($appointment->user, $appointment));
        }

    }
}
