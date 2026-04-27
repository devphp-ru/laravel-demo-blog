<?php

declare(strict_types=1);

namespace App\Services\ArticleComments;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class ArticleCommentService
{
    public function __construct(private ArticleCommentRepository $articleCommentRepository) {}

    public function getAllAdminsWithPagination(
        Request $request,
        int $perPage,
    ): LengthAwarePaginator
    {
        return $this->articleCommentRepository->getAllAdminsWithPagination($request, $perPage);
    }

}
