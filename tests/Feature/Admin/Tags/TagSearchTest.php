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

class TagSearchTest extends TestCase
{
    use RefreshDatabase;

    public TagService $tagService;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(AdminUser::factory()->create(), 'admin');
        $this->tagService = new TagService(new TagRepository());
    }

    public function testSearchCategoriesToName(): void
    {
        $this->tagFactory();
        $item = Tag::factory()->create([
            'slug' => Str::slug('Test tag'),
            'name' => 'Test tag',
        ]);
        $perPage = 10;
        $request = new Request(['q' => 'Tag']);

        $response = $this->get(route('tags.index'));
        $tags = $this->tagService->getAllAdminsWithPagination($request, $perPage);
        $tag = $tags->first();

        $response->assertStatus(200);
        $this->assertCount(1, $tags);
        $this->assertSame($item->name, $tag->name);
        $this->assertSame($item->slug, $tag->slug);
    }

    public function testSearchWithoutData(): void
    {
        $perPage = 10;
        $this->tagFactory();
        $request = new Request(['q' => '']);

        $response = $this->get(route('tags.index'));
        $tags = $this->tagService->getAllAdminsWithPagination($request, $perPage);

        $response->assertStatus(200);
        $this->assertFalse($tags->isEmpty());
    }

    private function tagFactory(): void
    {
        Tag::factory(15)->create();
    }

}
