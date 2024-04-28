<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(mt_rand(1, 2), true);
        $text = '<p>' . implode('</p><p>', fake()->paragraphs(mt_rand(2, 5))) . '</p>';

        return [
            'slug' => Str::slug($name),
            'name' => $name,
            'content' => $text,
            'is_active' => '1',
        ];
    }
}
