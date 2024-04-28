<?php

namespace App\Services\Categories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

final class CategoryRepository
{
    public function getForSelect(): SupportCollection
    {
        return Category::orderBy('parent_id')->get()->pluck('name', 'id');
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        $builder = Category::with('parent', 'children');
        $builder = $this->adminSearch($request, $builder);

        return $builder
            ->orderBy('parent_id')
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

            $builder->orWhere(DB::raw('lower(name)'), 'like', $like);
        }

        return $builder;
    }

    public function create(CategoryRequest $request): ?Category
    {
        $result = Category::create($request->only((new Category())->getFillable()));

        return $result ?? null;
    }

    public function update(
        CategoryRequest $request,
        Category $category,
    ): ?Category
    {
        $result = $category->update($request->only($category->getFillable()));

        return $result ? $category : null;
    }

    public function destroy(Category $category): bool
    {
        return $category->delete();
    }

}
