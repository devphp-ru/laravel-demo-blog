<?php

namespace Tests\Feature\Admin\Articles;

use App\Models\AdminUser;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\Articles\ArticleRepository;
use App\Services\Articles\ArticleService;
use App\Services\Categories\CategoryRepository;
use App\Services\Categories\CategoryService;
use App\Services\Tags\TagRepository;
use App\Services\Tags\TagService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public ArticleService $articleService;
    public CategoryService $categoryService;
    public TagService $tagService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->articleService = new ArticleService(new ArticleRepository());
        $this->categoryService = new CategoryService(new CategoryRepository());
        $this->tagService = new TagService(new TagRepository());
    }

    public function testGetViewCategoriesIndex(): void
    {
        Category::factory(10)->create();
        Article::factory(20)->create();
        $title = 'Статьи';
        $perPage = 10;
        $request = new Request();

        $response = $this->get(route('articles.index'));
        $articles = $this->articleService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.index');
        $response->assertViewHas([
            'title' => $title,
            'paginator' => $articles,
        ]);

        (new Filesystem())->cleanDirectory('public/uploads/dev_articles');
    }

    public function testGetViewCreateArticle(): void
    {
        Category::factory(10)->create();
        $title = 'Добавить';

        $response = $this->get(route('articles.create'));
        $categories = $this->categoryService->getForSelect();
        $tags = $this->tagService->getForSelect();

        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.create');
        $response->assertViewHas([
            'title' => $title,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function testCanCreateArticle(): void
    {
        $categories = Category::factory(10)->create();
        $image = UploadedFile::fake()->image('test.jpg');
        $filename = 'uploads/articles/' . $image->hashName();
        $categoryId = $categories->first()->id;

        $response = $this->post(route('articles.store'), [
            'category_id' => $categoryId,
            'title' => 'Test',
            'content' => 'Test',
            'image' => $image,
            'views' => '0',
            'is_active' => '1',
            'tags' => [1, 2, 3],
        ]);
        Storage::delete($filename);

        $response->assertStatus(302);
        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Article::class, 1);
        $this->assertDatabaseHas(Article::class, [
            'category_id' => $categoryId,
            'slug' => Str::slug('Test'),
            'title' => 'Test',
            'content' => 'Test',
            'thumbnail' => $filename,
            'views' => '0',
            'is_active' => '1',
        ]);
        $this->assertDAtabaseCount('article_tag', 3);
    }

    public function testGetViewArticlesEdit(): void
    {
        Category::factory(10)->create();
        $item = Article::factory()->create();
        $title = 'Редактировать: ' . $item->title;

        $response = $this->get(route('articles.edit', $item));
        $categories = $this->categoryService->getForSelect();
        $tags = $this->tagService->getForSelect();
        Storage::delete($item->thumbnail);

        $response->assertStatus(200);
        $response->assertViewIs('admin.articles.edit');
        $response->assertViewHas([
            'title' => $title,
            'item' => $item,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function testCanUpdateArticle(): void
    {
        $categories = Category::factory(10)->create();
        $categoryId = $categories->last()->id;
        $item = Article::factory()->create([
            'category_id' => $categories->first()->id,
        ]);
        $image = UploadedFile::fake()->image('test.jpg');
        $filename = 'uploads/articles/' . $image->hashName();

        $response = $this->put(route('articles.update', $item), [
            'category_id' => $categoryId,
            'title' => 'Test',
            'content' => 'Test',
            'image' => $image,
            'views' => '100',
            'is_active' => '0',
            'tags' => [1],
        ]);
        Storage::delete($item->thumbnail);
        Storage::delete($filename);

        $response->assertStatus(302);
        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Article::class, 1);
        $this->assertDatabaseHas(Article::class, [
            'category_id' => $categoryId,
            'slug' => Str::slug('Test'),
            'title' => 'Test',
            'content' => 'Test',
            'thumbnail' => $filename,
            'views' => '100',
            'is_active' => '0',
        ]);
        $this->assertDAtabaseCount('article_tag', 1);
    }

    public function testCanDeleteArticle(): void
    {
        Category::factory(10)->create();
        $item = Article::factory()->create();

        $response = $this->delete(route('articles.destroy', $item));
        Storage::delete($item->thumbnail);

        $response->assertStatus(302);
        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Успешно удалено.');
        $this->assertDatabaseCount(Article::class, 0);
        $this->assertDAtabaseCount('article_tag', 0);
    }

}
