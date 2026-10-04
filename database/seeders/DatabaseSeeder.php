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

        if (\App\Models\addCampus::count() == 0) {
            \App\Models\addCampus::factory(1)->create();
        }
        if (\App\Models\academicsessions::count() == 0) {
            \App\Models\academicsessions::factory(1)->create();
        }
        if (\App\Models\Department::count() == 0) {
            \App\Models\Department::factory(1)->create();
        }
        if (\App\Models\Scale::count() == 0) {
            \App\Models\Scale::factory(1)->create();
        }
        if (\App\Models\Role::count() == 0) {
            \App\Models\Role::factory(1)->create();
        }
        if (\App\Models\Admin::count() == 0) {
            \App\Models\Admin::factory(1)->create();
        }

        $this->call(IconsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(DefaultConfigurationSeeder::class);
    }
}
