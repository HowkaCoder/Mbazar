<?php

namespace Database\Factories;

use App\Models\Animals;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalsFactory extends Factory
{
    protected $model = Animals::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'img1' => "https://picsum.photos/id/237/200/300",
            'img2' => "https://picsum.photos/id/237/200/300",
            'img3' => "https://picsum.photos/id/237/200/300",
            'price' => $this->faker->randomDigit,
            'view' => $this->faker->randomDigit,
            'phone' => $this->faker->phoneNumber,
            'user_id' => 1,
            'category_id' => 1,
            'city_id' => 1,
            'top' => 0,
            'from' => 'app',
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date,
        ];
    }
}
