<?php

namespace Tests\Feature\Admin\Categories;

use App\Models\AdminUser;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
    }

    public function testCategoryValidateWithEmptyFields(): void
    {
        $text = str_repeat('test test test', 65001);

        $this->post(route('categories.store'), [
            'parent_id' => '',
            'name' => '',
            'content' => $text,
            'is_active' => '',
        ])->assertInvalid([
            'parent_id' => 'Количество символов в поле Категории должно быть 0 или больше.',
            'name' => 'Поле Имя обязательно.',
            'content' => 'Количество символов в значении поля Контент не может превышать 65000.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertFalse(session()->hasOldInput('parent_id'));
        $this->assertFalse(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertFalse(session()->hasOldInput('is_active'));
    }

    public function testCategoryValidateIncorrectData(): void
    {
        $text = str_repeat('test test test', 65001);

        $this->post(route('categories.store'), [
            'parent_id' => 'test',
            'name' => '!test@',
            'content' => $text,
            'is_active' => '!!!0',
        ])->assertInvalid([
            'parent_id' => 'Количество символов в поле Категории должно быть 0 или больше.',
            'name' => 'Значение поля Имя имеет некорректный формат.',
            'content' => 'Количество символов в значении поля Контент не может превышать 65000.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertTrue(session()->hasOldInput('parent_id'));
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertTrue(session()->hasOldInput('is_active'));
    }

    public function testCategoryValidateWithExistsName(): void
    {
        $item = Category::factory()->create();

        $this->post(route('categories.store'), [
            'parent_id' => '0',
            'name' => $item->name,
            'content' => 'content',
            'is_active' => '1',
        ])->assertInvalid([
            'name' => 'Такое значение поля Имя уже существует.',
        ]);

        $this->assertTrue(session()->hasOldInput('parent_id'));
        $this->assertTrue(session()->hasoldInput('name'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertTrue(session()->hasOldInput('is_active'));
    }

    public function testValidateCorrectData(): void
    {
        $response = $this->post(route('categories.store', [
            'parent_id' => '0',
            'name' => 'test',
            'content' => 'content',
            'is_active' => '1',
        ]));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Category::class, 1);
        $this->assertDatabaseHas(Category::class, [
            'parent_id' => '0',
            'slug' => Str::slug('test'),
            'name' => 'test',
            'content' => 'content',
            'is_active' => '1',
        ]);
    }

}
