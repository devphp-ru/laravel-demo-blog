<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $i = 1;
        $title = fake()->unique()->words(mt_rand(3, 5), true);
        $content = '<p>' . implode('</p><p>', fake()->paragraphs(mt_rand(3, 7))) . '</p>';
        $category = Category::whereNotIn('id', [1, 2, 3])->inRandomOrder()->first();
        $date = \date('Y-m-d H:i:s', \strtotime('-1 years +1 month'));
        $newDate = \date('Y-m-d H:i:s', \strtotime($date . "+{$i} day"));
        $i++;

        return [
            'category_id' => $category->id,
            'slug' => Str::slug($title),
            'title' => ucfirst($title),
            'content' => $content,
            'thumbnail' => Str::after(Storage::url(
                'uploads/dev_articles/' . $this->faker->image(storage_path('app/uploads/dev_articles/'), 640, 520, null, false)
            ), '/storage/'),
            'views' => '0',
            'is_active' => '1',
            'created_at' => $newDate,
            'updated_at' => $newDate,
        ];
    }

}
