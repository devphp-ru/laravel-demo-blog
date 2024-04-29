<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Services\Articles\ArticleService;
use App\Services\Categories\CategoryService;
use App\Services\Tags\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends BaseController
{
    public function __construct(private ArticleService $articleService) {}

    public function index(Request $request): View
    {
        $title = 'Статьи';
        $perPage = 10;
        $articles = $this->articleService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.articles.index', [
            'title' => $title,
            'paginator' => $articles,
        ]);
    }

    public function create(
        CategoryService $categoryService,
        TagService $tagService,
    ): View
    {
        $title = 'Добавить';

        $categories = $categoryService->getForSelect();
        $tags = $tagService->getForSelect();

        return view('admin.articles.create', [
            'title' => $title,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        $result = $this->articleService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('articles.index')->with('success', 'Успешно сохранено.');
    }

    public function show(Article $article): View
    {
        abort(404);
    }

    public function edit(
        Article $article,
        CategoryService $categoryService,
        TagService $tagService,
    ): View
    {
        $title = 'Редактировать: ' . $article->title;

        $categories = $categoryService->getForSelect();
        $tags = $tagService->getForSelect();

        return view('admin.articles.edit', [
            'title' => $title,
            'item' => $article,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function update(
        ArticleRequest $request,
        Article $article,
    ): RedirectResponse
    {
        $result = $this->articleService->update($request, $article);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('articles.index')->with('success', 'Успешно сохранено.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $result = $this->articleService->destroy($article);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка удаления.']);
        }

        return redirect()->route('articles.index')->with('success', 'Успешно удалено.');
    }

}
