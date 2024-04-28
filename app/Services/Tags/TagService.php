<?php

namespace App\Services\Tags;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

final class TagService
{
    public function __construct(private TagRepository $tagRepository) {}

    public function getForSelect(): SupportCollection
    {
        return $this->tagRepository->getForSelect();
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->tagRepository->getAllAdminsWithPagination($request, $perPage);
    }

    public function create(TagRequest $request): ?Tag
    {
        $request->merge(['is_active' => $request->input('is_active', 0)]);

        return $this->tagRepository->create($request);
    }

    public function update(
        TagRequest $request,
        Tag $tag,
    ): ?Tag
    {
        $tag->slug = null;
        $request->merge(['is_active' => $request->input('is_active', 0)]);

        return $this->tagRepository->update($request, $tag);
    }

    public function destroy(Tag $tag): bool
    {
        return $this->tagRepository->destroy($tag);
    }

}
