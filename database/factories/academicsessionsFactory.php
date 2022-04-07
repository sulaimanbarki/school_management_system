<?php

namespace Database\Factories;

use App\Models\academicsessions;
use Illuminate\Database\Eloquent\Factories\Factory;

class academicsessionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = academicsessions::class;
    
    public function definition()
    {
        return [
            'Session' => "Default",
            'CampusID' => 1,
            'SessionType' => "Anual",
            'StartDate' => date('Y-m-d'),
            'EndDate' => date('Y-m-d'),
            'IsActive' => 1,
            'IsCurrent' => 1,
        ];
    }
}
