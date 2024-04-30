<?php

namespace App\Services\Articles;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ArticleRepository
{
    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = Article::with('category', 'tags', 'comments');
        $builder = $this->adminSearch($request, $builder);

        return $builder
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    private function adminSearch(
        Request $request,
        Builder $builder,
    ): Builder
    {
        if ($request->filled('q') ) {
            $query = \trim($request->input('q'));
            $query = \preg_replace('#[^0-9-a-zA-ZА-Яа-яёЁ@\.]#u', ' ', $query);
            $query = \preg_replace('#\s+#u', ' ', $query);
            $query = \mb_strtolower(\trim($query));
            $like = "%{$query}%";

            $builder->orWhere(DB::raw('lower(title)'), 'like', $like);
        }

        return $builder;
    }

    public function create(ArticleRequest $request): ?Article
    {
        $result = Article::create($request->only((new Article())->getFillable()));
        $result ? $result->tags()->sync($request->input('tags')) : null;

        return $result ?? null;
    }

    public function update(
        ArticleRequest $request,
        Article $article,
    ): ?Article
    {
        $result = $article->update($request->only($article->getFillable()));
        $result ? $article->tags()->sync($request->input('tags', [])) : null;

        return $result ? $article : null;
    }

    public function destroy(Article $article): bool
    {
        $result = $article->delete();
        $result ? $article->tags()->sync([]) : null;

        return $result;
    }

}
