<?php

namespace Database\Seeders;

use App\Models\Animals;
use Illuminate\Database\Seeder;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Animals::factory(200)->create();
    }
}
