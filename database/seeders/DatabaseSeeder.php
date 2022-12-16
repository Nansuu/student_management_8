<?php

namespace Database\Seeders;

use App\Models\Student;
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
        // \App\Models\User::factory(10)->create();
        Student::factory()->count(500)->create();

        \App\Models\User::factory()->create([
            'name' => 'Haruto',
            'email' => 'watanabe@haruto.com',
            'password'=> 'haruto123'
        ]);
    }
}
