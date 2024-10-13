<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VaccinationSearchController extends Controller
{
    public function index() {
        return Inertia::render('Search');
    }

    public function search(Request $request) {
        $user = User::where('nid', $request->nid)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $status = $user->status;
        $date = '';

        if ($user->scheduled_vaccine_date < now()) {
            $status = 'Vaccinated';
        }

        if ($status === 'Scheduled') {
            $date = Carbon::parse($user->scheduled_vaccine_date)->format('F j, Y');
        }

        return response()->json(['status' => $status, 'date' => $date]);
    }
}
