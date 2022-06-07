<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animals;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\Models\Animals::class, 50)->create();
        $this->call([
           AnimalsSeeder::class,
        ]);
    }
}
