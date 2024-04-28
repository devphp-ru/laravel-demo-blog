<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\AdminUser;
use App\Models\Category;
use App\Services\Categories\CategoryRepository;
use App\Services\Categories\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class CategorySearchTest extends TestCase
{
    use RefreshDatabase;

    public CategoryService $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->categoryService = new CategoryService(new CategoryRepository());
    }

    public function testSearchCategoriesToName(): void
    {
        $this->categoriesFactory();
        $item = Category::factory()->create([
            'name' => 'Test category',
        ]);
        $perPage = 10;
        $request = new Request(['q' => 'TesT']);

        $response = $this->get(route('categories.index'));

        $categories = $this->categoryService->getAllAdminsWithPagination($request, $perPage);
        $category = $categories->first();

        $response->assertStatus(200);
        $this->assertCount(1, $categories);
        $this->assertSame($item->name, $category->name);
    }

    public function testSearchWithoutData(): void
    {
        $this->categoriesFactory();
        $perPage = 10;
        $request = new Request(['q' => '']);

        $response = $this->get(route('categories.index'));

        $categories = $this->categoryService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $this->assertFalse($categories->isEmpty());
    }

    private function categoriesFactory(): void
    {
        Category::factory(25)->create();
    }
    
}
