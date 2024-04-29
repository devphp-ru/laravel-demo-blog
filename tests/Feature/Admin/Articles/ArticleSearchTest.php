<?php

namespace Tests\Feature\Admin\Articles;

use App\Models\AdminUser;
use App\Models\Article;
use App\Models\Category;
use App\Services\Articles\ArticleRepository;
use App\Services\Articles\ArticleService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class ArticleSearchTest extends TestCase
{
    use RefreshDatabase;

    public ArticleService $articleService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->articleService = new Articleservice(new ArticleRepository());
    }

    public function testSearchCategoriesToName(): void
    {
        Category::factory(10)->create();
        Article::factory(10)->create();
        $item = Article::factory()->create([
            'title' => 'Test',
        ]);
        $perPage = 10;
        $request = new Request(['q' => 'test']);

        $response = $this->get(route('articles.index'));
        $articles = $this->articleService->getAllAdminsWithPagination($request, $perPage);
        $article = $articles->first();

        $response->assertStatus(200);
        $this->assertCount(1, $articles);
        $this->assertSame($item->title, $article->title);

        (new Filesystem())->cleanDirectory('public/uploads/dev_articles');
    }

    public function testSearchCategoriesWithoutName(): void
    {
        Category::factory(10)->create();
        Article::factory(10)->create();
        $perPage = 10;
        $request = new Request(['q' => '']);

        $response = $this->get(route('articles.index'));
        $articles = $this->articleService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $this->assertCount(10, $articles);

        (new Filesystem())->cleanDirectory('public/uploads/dev_articles');
    }

}
