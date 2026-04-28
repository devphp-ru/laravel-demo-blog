<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleCommentController extends Controller
{

    public function deleteComment(Request $request): JsonResponse
    {
        $result = ArticleComment::find($request->input('id'))->delete();

        return response()->json([
            'status' => $result,
            'message' => $result ? __('Успешно удалено.') : __('Ошибка удаления.'),
        ])->setStatusCode($result ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

}
