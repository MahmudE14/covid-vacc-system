<?php

namespace App\Services;

use App\Models\User;
use App\Models\VaccineCenter;
use App\Models\VaccineAppointment;
use App\Models\VaccineAppointmentCount;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentService
{
    /**
     * Schedule a vaccine appointment for a user.
     *
     * @param User $user
     * @return VaccineAppointment|null
     */
    public function scheduleAppointment(User $user, VaccineCenter $selected_center)
    {
        $scheduled_date = $this->findNextAvailableDate($selected_center->id);

        if (!$scheduled_date) {
            return null;
        }

        try {
            DB::beginTransaction();

            // entry an new appointment
            $appointment = VaccineAppointment::create([
                'user_id' => $user->id,
                'vaccine_center_id' => $selected_center->id,
                'scheduled_date' => $scheduled_date,
                'status' => 'Scheduled',
            ]);

            // increase appointment count
            $appointment_count = VaccineAppointmentCount::firstOrCreate(
                ['date' => now()->toDateString(), 'vaccine_center_id' => $selected_center->id],
                ['appointments_count' => 0] // default if not exists
            );
            $appointment_count->incrementAppointmentCount($selected_center->daily_capacity);

            // update user status and scheduled date
            $user->update([
                'status' => 'Scheduled',
                'scheduled_vaccine_date' => $scheduled_date,
            ]);

            DB::commit();

            return $appointment;

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return null;
        }
    }

    /**
     * Find the next available weekday for a given center.
     *
     * @param int $centerId
     * @return string|null
     */
    protected function findNextAvailableDate($centerId)
    {
        $days_to_check = 45;

        // Check capacity for upcoming weekdays (excluding weekends).
        // starting from tomorrow. This checks for availability for up to 45 days.
        $date = Carbon::now()->addDay();

        for ($i = 0; $i < $days_to_check; $i++) {
            if ($date->isWeekend()) {
                $date->addDay();
                continue;
            }

            $appointmentsCount = VaccineAppointmentCount::where('vaccine_center_id', $centerId)
                ->whereDate('date', $date->format('Y-m-d'))
                ->count();

            $center = VaccineCenter::find($centerId);

            if ($appointmentsCount < $center->daily_capacity) {
                return $date->format('Y-m-d'); // Found available date
            }

            // Not found today. Check the next day
            $date->addDay();
        }

        return null;
    }
}
