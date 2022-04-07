<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\addCampus::factory(1)->create();
        \App\Models\academicsessions::factory(1)->create();
        \App\Models\Department::factory(1)->create();
        \App\Models\Scale::factory(1)->create();
        
        \App\Models\Role::factory(1)->create();
        \App\Models\Admin::factory(1)->create();

        $this->call(IconsSeeder::class);
        $this->call(PagesSeeder::class);
    }
}
