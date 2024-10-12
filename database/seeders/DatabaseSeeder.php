<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaccineCenter;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            VaccineCenterSeeder::class,
        ]);

        User::factory()->create([
            'nid' => '1234567890',
            'name' => 'Admin Khan',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'nid' => '1234567890',
            'phone' => '1234567890',
            'vaccine_center_id' => VaccineCenter::first()?->id
        ]);
    }
}
