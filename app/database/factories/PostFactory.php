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
        return [
            'blogTitle' => fake()->sentence(),
            'blogHTML' => fake()->randomHtml(),
            'coverPhotoName' => 'avatar.jpg',
            'coverPhotoURL' => 'coverPhotos/avatar.jpg'
        ];
    }
}
