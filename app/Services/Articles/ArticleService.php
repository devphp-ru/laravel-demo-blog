<?php

namespace App\Services\Articles;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

final class ArticleService
{
    public function __construct(private ArticleRepository $ArticleRepository) {}

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->ArticleRepository->getAllAdminsWithPagination($request, $perPage);
    }

    public function create(ArticleRequest $request): ?Article
    {
        $request->merge(['is_active' => $request->input('is_active', '0')]);
        if ($request->hasFile('image')) {
            $request->merge(['thumbnail' => $request->file('image')->store('/uploads/articles', 'local')]);
        }

        return $this->ArticleRepository->create($request);
    }

    public function update(
        ArticleRequest $request,
        Article $article,
    ): ?Article
    {
        $article->slug = null;
        $request->merge(['is_active' => $request->input('is_active', '0')]);

        if ($request->hasFile('image')) {
            Storage::delete(asset($article->thumbnail));
            $request->merge(['thumbnail' => $request->file('image')->store('/uploads/articles', 'local')]);
        }

        return $this->ArticleRepository->update($request, $article);
    }

    public function destroy(Article $article): bool
    {
        if ($article->thumbnail) {
            Storage::delete($article->thumbnail);
        }

        return $this->ArticleRepository->destroy($article);
    }

}
