<?php

declare(strict_types=1);

namespace Tests\Feature\Admin\Tags;

use App\Models\AdminUser;
use App\Models\Tag;
use App\Services\Tags\TagRepository;
use App\Services\Tags\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_validate_empty_field(): void
    {
        $this->post(route('tags.store'), [
            'name' => '',
        ])->assertInvalid([
            'name' => 'Поле Имя обязательно.',
        ]);

        $this->assertFalse(session()->hasOldInput('name'));
    }

    public function test_validate_incorrect_data(): void
    {
        $this->post(route('tags.store'), [
            'name' => '!name 1234 @',
            'content' => Str::random(65001),
            'is_active' => '1!2',
        ])->assertInvalid([
            'name' => 'Значение поля Имя имеет некорректный формат.',
            'content' => 'Количество символов в значении поля Контент не может превышать 65000.',
            'is_active' => 'Количество символов в поле Статус должно быть 0 или больше.',
        ]);

        $this->assertTrue(session()->hasOldInput('name'));
    }

    public function test_correct_name_tag(): void
    {
        $this->post(route('tags.store'), [
            'name' => 'Tag',
            'content' => 'content tag',
            'is_active' => '1',
        ]);

        $tag = Tag::query()->get()->first();

        $this->assertNotEmpty($tag);

        $this->assertDatabaseCount(Tag::class, 1);
        $this->assertDatabaseHas(Tag::class, [
            'slug' => Str::slug('Tag'),
            'name' => 'Tag',
            'content' => 'content tag',
            'is_active' => '1',
        ]);
    }

}
