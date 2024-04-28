<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\Tags\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends BaseController
{
    public function __construct(private TagService $tagService) {}

    public function index(Request $request): View
    {
        $title = __('Тэги');
        $perPage = 10;

        $tags = $this->tagService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.tags.index', [
            'title' => $title,
            'paginator' => $tags,
        ]);
    }

    public function create(): View
    {
        $title = __('Добавить');

        return view('admin.tags.create', [
            'title' => $title,
        ]);
    }

    public function store(TagRequest $request): RedirectResponse
    {
        $result = $this->tagService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('tags.index')->with('success', 'Успешно сохранено.');
    }

    public function edit(Tag $tag): View
    {
        $title = __('Редактировать: ' . $tag->name);

        return view('admin.tags.edit', [
            'title' => $title,
            'item' => $tag,
        ]);
    }

    public function update(
        TagRequest $request,
        Tag $tag,
    )
    {
        $result = $this->tagService->update($request, $tag);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('tags.index')->with('success', 'Успешно сохранено.');
    }

    public function destroy(Tag $tag)
    {
        $result = $this->tagService->destroy($tag);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка удаления.']);
        }

        return redirect()->route('tags.index')->with('success', 'Успешно удалено.');
    }

}
