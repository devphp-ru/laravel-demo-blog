<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Categories\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends BaseController
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(Request $request): View
    {
        $title = __('Категории');
        $perPage = 5;

        $categories = $this->categoryService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.categories.index', [
            'title' => $title,
            'paginator' => $categories,
        ]);
    }

    public function create(): View
    {
        $title = __('Добавить');

        $categories = $this->categoryService->getForSelect();

        return view('admin.categories.create', [
            'title' => $title,
            'categories' => $categories,
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $request->merge(['is_active' => $request->input('is_active', 0)]);

        $result = $this->categoryService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('categories.index')->with('success', 'Успешно сохранено.');
    }

    public function edit(Category $category): View
    {
        $title = __('Редактировать: ' . $category->name);

        $categories = $this->categoryService->getForSelect();

        return view('admin.categories.edit', [
            'title' => $title,
            'item' => $category,
            'categories' => $categories,
        ]);
    }

    public function update(
        CategoryRequest $request,
        Category $category,
    ): RedirectResponse
    {
        $category->slug = null;
        $request->merge(['is_active' => $request->input('is_active', 0)]);

        $result = $this->categoryService->update($request, $category);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('categories.index')->with('success', 'Успешно сохранено.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $result = $this->categoryService->destroy($category);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка удаления.']);
        }

        return redirect()->route('categories.index')->with('success', 'Успешно удалено.');
    }

}
