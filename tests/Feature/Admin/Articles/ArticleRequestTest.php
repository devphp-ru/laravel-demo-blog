<?php

namespace Tests\Feature\Admin\Articles;

use App\Models\AdminUser;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleRequestTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
    }

    public function testArticleValidateWithEmptyData(): void
    {
        $this->post(route('articles.store'), [
            'category_id' => '',
            'title' => '',
            'content' => '',
            'is_active' => '',
        ])->assertInvalid([
            'category_id' => 'Количество символов в поле Категории должно быть 0 или больше.',
            'title' => 'Поле Название обязательно.',
            'content' => 'Поле Контент обязательно.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertFalse(session()->hasOldInput('category_id'));
        $this->assertFalse(session()->hasOldInput('name'));
        $this->assertFalse(session()->hasOldInput('content'));
        $this->assertFalse(session()->hasOldInput('is_active'));
    }

    public function testArticleValidateWithIncorrectData(): void
    {
        $text = Str::repeat('test', 65001);
        $title = Str::repeat('test', 256);

        $this->post(route('articles.store'), [
            'category_id' => 'n',
            'title' => $title,
            'content' => $text,
            'image' => UploadedFile::fake()->image('test.txt'),
            'is_active' => 'n',
        ])->assertInvalid([
            'category_id' => 'Количество символов в поле Категории должно быть 0 или больше.',
            'title' => 'Количество символов в значении поля Название не может превышать 255.',
            'content' => 'Количество символов в значении поля Контент не может превышать 65000.',
            'image' => 'Файл, указанный в поле Изображение, должен быть изображением.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertTrue(session()->hasOldInput('category_id'));
        $this->assertTrue(session()->hasOldInput('title'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertTrue(session()->hasOldInput('is_active'));
    }

    public function testValidateUploadImageExtension(): void
    {
        Category::factory(10)->create();
        $item = Article::factory()->create();

        $this->post(route('articles.store'), [
            'category_id' => '0',
            'title' => 'Test',
            'content' => 'Test',
            'image' => UploadedFile::fake()->image('test.gif'),
            'is_active' => '0',
        ])->assertInvalid([
            'image' => 'Файл, указанный в поле Изображение, должен быть одного из следующих типов: png, jpeg, jpg, webp.',
        ]);
        Storage::delete($item->thumbnail);

        $this->assertTrue(session()->hasOldInput('category_id'));
        $this->assertTrue(session()->hasOldInput('title'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertFalse(session()->hasOldInput('image'));
        $this->assertTrue(session()->hasOldInput('is_active'));
    }

    public function testValidateArticleNameExists(): void
    {
        Category::factory(10)->create();
        $item = Article::factory()->create([
            'title' => 'Test article',
        ]);

        $this->post(route('articles.store'), [
            'category_id' => '0',
            'title' => 'Test article',
            'content' => 'Test content',
            'is_active' => '1',
        ])->assertInvalid([
            'title' => 'Такое значение поля Название уже существует.',
        ]);
        Storage::delete($item->thumbnail);

        $this->assertTrue(session()->hasOldInput('category_id'));
        $this->assertTrue(session()->hasOldInput('title'));
        $this->assertTrue(session()->hasOldInput('content'));
        $this->assertTrue(session()->hasOldInput('is_active'));
    }

    public function testValidateCorrectData(): void
    {
        $categories = Category::factory(10)->create();
        $image = UploadedFile::fake()->image('test.jpg');
        $filename = 'uploads/articles/' . $image->hashName();

        $response = $this->post(route('articles.store'), [
            'category_id' => $categories->first()->id,
            'title' => 'Test',
            'content' => 'Test',
            'image' => $image,
            'views' => '10',
            'is_active' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Article::class, 1);
        $this->assertDatabaseHas(Article::class, [
            'category_id' => $categories->first()->id,
            'slug' => Str::slug('Test'),
            'title' => 'Test',
            'content' => 'Test',
            'thumbnail' => $filename,
            'views' => '10',
            'is_active' => '1',
        ]);
        Storage::disk('local')->assertExists($filename);
        Storage::delete($filename);
    }

}
