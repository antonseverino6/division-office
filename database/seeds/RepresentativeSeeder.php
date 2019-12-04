<?php

use App\Representative;
use Illuminate\Database\Seeder;

class RepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Representative::create([
            'name' => 'SDO Rizal',
        ]);
    }
}
