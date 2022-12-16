<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'roll_no' => $this->faker->numerify('mkpt- ####') ,
            'student_name' => $this->faker->name,
            'age' => rand(15, 30),
            'reg_date'=>$this->faker->dateTimeThisMonth()->format('Y-m-d'),
            ];
    }
}
