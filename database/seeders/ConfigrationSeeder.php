<?php

namespace Database\Seeders;

use App\Models\addCampus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        // DB::beginTransaction();
        // DB::unprepared('SET IDENTITY_INSERT configurations ON');
        Campus::factory()->times(1)->create();
        // addCampus::factory()->times(1)->create();
        // DB::unprepared('SET IDENTITY_INSERT configurations OFF');
        // DB::commit();




    }
}
