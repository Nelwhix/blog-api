<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomNum = mt_rand(1, 500);
        return [
            'blogTitle' => fake()->sentence(),
            'coverPhotoName' => 'avatar' . $randomNum  . '.jpg',
            'coverPhotoURL' => 'https://devleads-api.com/avatar' . $randomNum . '.jpg',
            'blogHTML' => fake()->randomHtml()
        ];
    }
}
