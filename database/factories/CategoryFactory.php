<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => fake()->name(),
            'category_short_detail' => fake()->paragraph(),
            'parent_category_id' => fake()->randomNumber(5, true),
            'category_icon_css' => fake()->title(),     
            'added_by' =>  User::factory(),            
            'updated_by' =>  User::factory(),
            'status' => 1,
            'created_at' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'updated_at' => fake()->dateTime()->format('Y-m-d H:i:s'),


                 
        ];
    }
}
