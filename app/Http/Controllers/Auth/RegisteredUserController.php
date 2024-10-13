<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VaccineCenter;
use App\Rules\NID;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'vaccine_centers' => VaccineCenter::all([
                'id',
                'name',
                'location',
                'daily_capacity',
            ]),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'nid' => ['required', 'string', 'unique:'.User::class, new NID],
            'phone' => 'nullable|string',
            'vaccine_center' => 'required|exists:vaccine_centers,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nid' => $request->nid,
            'phone' => $request->phone,
            'vaccine_center_id' => $request->vaccine_center,
        ]);

        event(new Registered($user));

        return redirect()->to('/search?redirect=registered');
    }
}
