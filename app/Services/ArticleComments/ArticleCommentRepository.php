<?php

namespace App\Services\ArticleComments;

use App\Models\ArticleComment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ArticleCommentRepository
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
            $query = \trim($request->input('q'));
            $query = \preg_replace('#[^0-9-a-zA-ZА-Яа-яёЁ@\.]#u', ' ', $query);
            $query = \preg_replace('#\s+#u', ' ', $query);
            $query = \mb_strtolower(\trim($query));
            $like = "%{$query}%";

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
