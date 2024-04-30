<?php

namespace Tests\Feature\Admin\Tags;

use App\Models\AdminUser;
use App\Models\Tag;
use App\Services\Tags\TagRepository;
use App\Services\Tags\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TagRequestTest extends TestCase
{
    use RefreshDatabase;

    public TagService $tagService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->tagService = new TagService(new TagRepository());
    }

    public function testTagValidateWithEmptyFields(): void
    {
        $this->post(route('tags.store'), [
            'name' => '',
        ])->assertInvalid([
            'name' => 'Поле Имя обязательно.',
        ]);

        $this->assertFalse(session()->hasOldInput('name'));
    }

    public function testTagValidateIncorrectData(): void
    {
        $text = str_repeat('text text text', 65001);

        $this->post(route('tags.store'), [
            'name' => '!name 1234 @',
            'content' => $text,
            'is_active' => '1!2',
        ])->assertInvalid([
            'name' => 'Значение поля Имя имеет некорректный формат.',
            'content' => 'Количество символов в значении поля Контент не может превышать 65000.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertTrue(session()->hasOldInput('name'));
    }

    public function testTagCorrectName(): void
    {
        $this->post(route('tags.store'), [
            'name' => 'Tag',
            'content' => 'content tag',
            'is_active' => '1',
        ]);

        $tag = Tag::get()->first();

        $this->assertNotEmpty($tag);
        $this->assertDatabaseCount(Tag::class, 1);
        $this->assertDatabaseHas(Tag::class, [
            'slug' => Str::slug('Tag'),
            'name' => 'Tag',
            'content' => 'content tag',
            'is_active' => '1',
        ]);
    }

    public function testCanDeleteTag(): void
    {
        $item = Tag::factory()->create();

        $response = $this->delete(route('tags.destroy', $item));

        $response->assertStatus(302);
        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Успешно удалено.');
        $this->assertDatabaseCount(Tag::class, 0);
    }

}
