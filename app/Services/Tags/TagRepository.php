<?php

declare(strict_types=1);

namespace App\Services\Tags;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

final readonly class TagRepository
{
    public function getForSelect(): SupportCollection
    {
        return Tag::query()->get()->pluck('name', 'id');
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = Tag::query();
        $builder = $this->adminSearch($request, $builder);

        return $builder
            ->orderBy('id', 'desc')
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

            $builder->orWhere(DB::raw('lower(name)'), 'like', $like);
        }

        return $builder;
    }

    public function create(TagRequest $request): ?Tag
    {
        $result = Tag::create($request->only(new Tag()->getFillable()));

        return $result ?? null;
    }

    public function update(
        TagRequest $request,
        Tag $tag,
    ): ?Tag
    {
        $result = $tag->update($request->only($tag->getFillable()));

        return $result ? $tag : null;
    }

    public function destroy(Tag $tag): bool
    {
        return $tag->delete();
    }

}
