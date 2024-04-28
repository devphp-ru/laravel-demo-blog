<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        static $i = 0;
        $name = fake()->unique()->words(mt_rand(1, 2), true);
        $content = '<p>' . implode('</p><p>', fake()->paragraphs(mt_rand(1, 3))) . '</p>';

        return [
            'parent_id' => (++$i > 4) ? mt_rand(1, 3) : 0,
            'slug' => Str::slug($name),
            'name' => $name,
            'content' => $content,
            'is_active' => '1',
        ];
    }
}
