<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\VaccineAppointmentMail;
use App\Models\Notification;
use App\Models\User;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new VaccineAppointmentMail($this->user, $this->user->appointment));
        Notification::create([
            'user_id' => $this->user->id,
            'message' => 'standard',
            'type' => 'email',
            'sent_at' => now(),
        ]);
    }
}
