<?php

declare(strict_types=1);

namespace App\Services\Articles;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final readonly class ArticleRepository
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
            $query = clearSearchBarFromCharacters($request->input('q'));
            $like = "%$query%";

            $builder->orWhere(DB::raw('lower(title)'), 'like', $like);
        }

        return $builder;
    }

    public function create(ArticleRequest $request): ?Article
    {
        $result = Article::create($request->only(new Article()->getFillable()));
        $result?->tags()->sync($request->input('tags'));

        return $result ?? null;
    }

    public function update(
        ArticleRequest $request,
        Article $article,
    ): ?Article
    {
        $result = $article->update($request->only($article->getFillable()));
        $article->tags()->sync($request->input('tags', []));

        return $result ? $article : null;
    }

    public function destroy(Article $article): bool
    {
        $result = $article->delete();
        $article->tags()->sync([]);

        return $result;
    }

}
