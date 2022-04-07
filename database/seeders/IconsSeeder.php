<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;

class IconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/icons.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Icon::create([
                    "icon_name" => $data['0'],
                    "icon_fa" => $data['1'],
                    "icon_code" => $data['2'],
                    "campusid" => $data['3'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
