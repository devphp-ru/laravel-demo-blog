<?php

declare(strict_types=1);

namespace App\Services\ArticleComments;

use App\Models\ArticleComment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final readonly class ArticleCommentRepository
{
    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = ArticleComment::with('article');
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

            $builder->orWhere(DB::raw('lower(username)'), 'like', $like);
            $builder->orWhere(DB::raw('lower(email)'), 'like', $like);
            $builder->orWhere(DB::raw('lower(comment)'), 'like', $like);
            $builder->orWhereIn('article_id', function ($builder) use ($like) {
                $builder->select('id')->from('articles')->where(DB::raw('lower(title)'), 'like', $like);
            });
        }

        return $builder;
    }

}
