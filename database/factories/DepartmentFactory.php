<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Department::class;
    public function definition()
    {
        return [
            'title' => "Default",
            'description' => "Some description",
            'isdisplay' => 1,
            'sequence' => 1,
            'campusid' => 1,
        ];
    }
}
