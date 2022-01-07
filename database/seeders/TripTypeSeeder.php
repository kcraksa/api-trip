<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TripType;

class TripTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trip_types = ['Business', 'Holiday', 'Family', 'Romantic'];

        foreach ($trip_types as $t) {
            TripType::create(['type' => $t]);   
        }
    }
}
