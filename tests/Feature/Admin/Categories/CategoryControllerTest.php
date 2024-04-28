<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\AdminUser;
use App\Models\Category;
use App\Services\Categories\CategoryRepository;
use App\Services\Categories\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public CategoryService $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->categoryService = new CategoryService(new CategoryRepository());
    }

    public function testGetViewCategoriesIndex(): void
    {
        $title = 'Категории';
        $perPage = 5;
        $this->categoriesFactory();
        $request = new Request();

        $response = $this->get(route('categories.index'));
        $categories = $this->categoryService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
        $response->assertViewHas([
            'title' => $title,
            'paginator' => $categories,
        ]);
    }

    public function testGetViewCategoriesCreate(): void
    {
        $title = 'Добавить';

        $response = $this->get(route('categories.create'));
        $categories = $this->categoryService->getForSelect();

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.create');
        $response->assertViewhas([
            'title' => $title,
            'categories' => $categories,
        ]);
    }

    public function testCanCategoryCreate(): void
    {
        $response = $this->post(route('categories.store'), [
            'parent_id' => '0',
            'name' => 'Test test',
            'content' => 'content',
            'is_active' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseHas(Category::class, [
            'parent_id' => '0',
            'slug' => Str::slug('Test test'),
            'name' => 'Test test',
            'content' => 'content',
            'is_active' => '1',
        ]);
    }

    public function testGetViewCategoryEdit(): void
    {
        $item = Category::factory()->create();
        $title = 'Редактировать: ' . $item->name;

        $response = $this->get(route('categories.edit', $item));
        $categories = $this->categoryService->getForSelect();

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.edit');
        $response->assertViewHas([
            'title' => $title,
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    public function testCanCategoryUpdate(): void
    {
        $item = Category::factory()->create();

        $response = $this->put(route('categories.update', $item), [
            'parent_id' => '0',
            'name' => 'Test category',
            'content' => 'Test content',
            'is_active' => '0',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseHas(Category::class, [
            'parent_id' => '0',
            'slug' => Str::slug('Test category'),
            'name' => 'Test category',
            'content' => 'Test content',
            'is_active' => '0',
        ]);
    }

    public function testCanCategoryDelete(): void
    {
        $this->categoriesFactory();
        $item = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $item));

        $response->assertStatus(302);
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Успешно удалено.');
        $this->assertDatabaseCount(Category::class, 10);
    }

    private function categoriesFactory(): void
    {
        Category::factory(10)->create();
    }

}
