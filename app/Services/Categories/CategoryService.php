<?php

namespace App\Services\Categories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

final class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository) {}

    public function getForSelect(): SupportCollection
    {
        return $this->categoryRepository->getForSelect();
    }

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->categoryRepository->getAllAdminsWithPagination($request, $perPage);
    }

    public function create(CategoryRequest $request): ?Category
    {
        return $this->categoryRepository->create($request);
    }

    public function update(
        CategoryRequest $request,
        Category $category,
    ): ?Category
    {
        return $this->categoryRepository->update($request, $category);
    }

    public function destroy(Category $category): bool
    {
        return $this->categoryRepository->destroy($category);
    }

}
