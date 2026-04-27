<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Categories;

use App\Models\AdminUser;
use App\Models\Category;
use App\Services\Categories\CategoryRepository;
use App\Services\Categories\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_get_view_categories(): void
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

    public function test_get_view_create_category(): void
    {
        $title = 'Добавить';

        $response = $this->get(route('categories.create'));
        $categories = $this->categoryService->getForSelect();

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.create');
        $response->assertViewHas([
            'title' => $title,
            'categories' => $categories,
        ]);
    }

    public function test_can_create_category(): void
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

    public function test_get_view_edit_category(): void
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

    public function test_can_update_category(): void
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

    public function test_can_delete_category(): void
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
