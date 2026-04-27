<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticleCommentController extends Controller
{
    public function changeStatus(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $value = $request->input('value');
        $result = ArticleComment::query()->where('id', '=', $id)->update(['is_active' => $value]);

        return response()->json([
            'status' => $result,
            'id' => $id,
            'value' => $value == 1 ? 0 : 1,
            'message' => $result ? __('Успешно изменено.') : __('Ошибка сохранения.'),
        ])->setStatusCode($result ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteComment(Request $request): JsonResponse
    {
        $result = ArticleComment::find($request->input('id'))->delete();

        return response()->json([
            'status' => $result,
            'message' => $result ? __('Успешно удалено.') : __('Ошибка удаления.'),
        ])->setStatusCode($result ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

}
