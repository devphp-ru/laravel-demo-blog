<?php

namespace App\Services\ArticleComments;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class ArticleCommentService
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
