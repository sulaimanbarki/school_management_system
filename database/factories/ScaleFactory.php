<?php

namespace Database\Factories;

use App\Models\Scale;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Scale::class;
    
    public function definition()
    {
        return [
            'name' => 1,
            'description' => "Some description",
            'basicpay' => 1,
            'yearlyincrement' => 1,
            'salarylimit' => 1,
            'eobiamount' => 1,
            'academicsession' => 1,
            'isactive' => 1,
            'sequence' => 1,
            'campusid' => "1",
        ];
    }
}
