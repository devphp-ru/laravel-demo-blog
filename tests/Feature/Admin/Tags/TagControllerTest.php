<?php

namespace Tests\Feature\Admin\Tags;

use App\Models\AdminUser;
use App\Models\Tag;
use App\Services\Tags\TagRepository;
use App\Services\Tags\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    public TagService $tagService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->tagService = new TagService(new TagRepository());
    }

    public function testGetViewTagsIndex(): void
    {
        $title = 'Тэги';
        $perPage = 10;
        Tag::factory(15)->create();
        $request = new Request();

        $response = $this->get(route('tags.index'));
        $tags = $this->tagService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $response->assertViewIs('admin.tags.index');
        $response->assertViewHas([
            'title' => $title,
            'paginator' => $tags,
        ]);
    }

    public function testGetViewTagsCreate(): void
    {
        $title = 'Добавить';

        $response = $this->get(route('tags.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.tags.create');
        $response->assertViewHas([
            'title' => $title,
        ]);
    }

    public function testCanCreateCategory(): void
    {
        $response = $this->post(route('tags.store'), [
            'name' => 'Test tag',
            'content' => 'Tag content',
            'is_active' => '1',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Tag::class, 1);
        $this->assertDatabaseHas(Tag::class, [
            'slug' => Str::slug('test tag'),
            'name' => 'Test tag',
            'content' => 'Tag content',
            'is_active' => '1',
        ]);
    }

    public function testGetViewTagsEdit(): void
    {
        $item = Tag::factory()->create();
        $title = 'Редактировать: ' . $item->name;

        $response = $this->get(route('tags.edit', $item));

        $response->assertStatus(200);
        $response->assertViewIs('admin.tags.edit');
        $response->assertViewHas([
            'title' => $title,
            'item' => $item,
        ]);
    }

    public function testCanUpdateTag(): void
    {
        $item = Tag::factory()->create();

        $response = $this->put(route('tags.update', $item), [
            'name' => 'New name tag',
            'content' => 'Tag content',
            'is_active' => '0',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success', 'Успешно сохранено.');
        $this->assertDatabaseCount(Tag::class, 1);
        $this->assertDatabaseHas(Tag::class, [
            'slug' => Str::slug('New name tag'),
            'name' => 'New name tag',
            'content' => 'Tag content',
            'is_active' => '0',
        ]);
    }

}
