<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleComment>
 */
class ArticleCommentFactory extends Factory
{
    public function definition(): array
    {
        static $i = 1;
        $article = Article::inRandomOrder()->first();
        $date = \date('Y-m-d H:i:s', \strtotime('-1 years +1 month'));
        $newDate = \date('Y-m-d H:i:s', \strtotime($date . "+{$i} day"));

        return [
            'parent_id' => $i++ > 10 && mt_rand(0, 1) ? mt_rand(11, 45) : 0,
            'article_id' => $article->id,
            'username' => fake()->name,
            'email' => fake()->email,
            'comment' => fake()->words(mt_rand(2, 20), true),
            'is_active' => '1',
            'created_at' => $newDate,
            'updated_at' => $newDate,
        ];
    }
}
