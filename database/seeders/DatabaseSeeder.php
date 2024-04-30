<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AdminUser;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new Filesystem())->cleanDirectory('storage/app/public/uploads/dev_articles');

        AdminUser::factory()->create([
            'username' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        AdminUser::factory(23)->create();
        User::factory(25)->create();
        Category::factory(10)->create();
        Tag::factory(15)->create();
        Article::factory(89)->create();
        ArticleComment::factory(57)->create();
    }

}
