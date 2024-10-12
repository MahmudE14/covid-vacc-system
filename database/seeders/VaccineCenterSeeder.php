<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = [
            ['name' => 'Uttara North', 'location' => 'Diabari, Uttara, Dhaka', 'daily_capacity' => 100],
            ['name' => 'Uttara Center', 'location' => 'Sector 14, Uttara, Dhaka', 'daily_capacity' => 200],
            ['name' => 'Uttara South', 'location' => 'Sector 9, Uttara, Dhaka', 'daily_capacity' => 250],
            ['name' => 'Pallabi', 'location' => 'Pallabi, Mirpur, Dhaka', 'daily_capacity' => 50],
            ['name' => 'Mirpur 11', 'location' => 'Mirpur 11, Dhaka', 'daily_capacity' => 80],
            ['name' => 'Mirpur 10', 'location' => 'Mirpur 10, Dhaka', 'daily_capacity' => 150],
            ['name' => 'Kazipara', 'location' => 'Kazipara, Dhaka', 'daily_capacity' => 450],
            ['name' => 'Shewrapara', 'location' => 'Shewrapara, Dhaka', 'daily_capacity' => 300],
            ['name' => 'Agargaon', 'location' => 'Agargaon, Dhaka', 'daily_capacity' => 90],
            ['name' => 'Bijoy Sarani', 'location' => 'Bijoy Sarani, Dhaka', 'daily_capacity' => 40],
            ['name' => 'Farmgate', 'location' => 'Farmgate, Dhaka', 'daily_capacity' => 450],
            ['name' => 'Karwan Bazar', 'location' => 'Karwan Bazar, Dhaka', 'daily_capacity' => 550],
            ['name' => 'Shahbagh', 'location' => 'Shahbagh, Dhaka', 'daily_capacity' => 100],
            ['name' => 'Dhaka University', 'location' => 'Dhaka University, Dhaka', 'daily_capacity' => 280],
            ['name' => 'Bangladesh Secretariat', 'location' => 'Bangladesh Secretariat, Dhaka', 'daily_capacity' => 300],
            ['name' => 'Motijheel', 'location' => 'Motijheel, Dhaka', 'daily_capacity' => 500],
        ];

        foreach ($centers as $center) {
            VaccineCenter::create($center);
        }
    }
}
