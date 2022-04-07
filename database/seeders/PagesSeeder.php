<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/pages.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Pages::create([
                    "page_head" => $data['0'],
                    "page_title" => $data['1'],
                    "page_link" => $data['2'],
                    "page_type" => $data['3'],
                    "icon_id" => $data['4'],
                    "page_order" => $data['5'],
                    "campusid" => $data['6'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
