<?php

namespace App\Mail;

use App\Models\User;
use App\Models\VaccineAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VaccineAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, VaccineAppointment $appointment)
    {
        $this->user = $user;
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'COVID Vaccine Appointment Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vaccine_appointment',
            with: [
                'user' => $this->user,
                'appointment' => $this->appointment,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
