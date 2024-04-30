<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleCommentController extends Controller
{
    public function changeStatus(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $value = $request->input('value');
        $result = ArticleComment::where('id', '=', $id)
            ->update(['is_active' => $value]);

        return response()->json([
            'status' => $result,
            'id' => $id,
            'value' => $value == 1 ? 0 : 1,
            'message' => $result ? 'Успешно изменено.' : 'Ошибка сохранения.',
        ])->setStatusCode(Response::HTTP_OK);
    }

    public function deleteComment(Request $request): JsonResponse
    {
        $result = ArticleComment::find($request->input('id'))->delete();

        return response()->json([
            'status' => $result,
            'message' => $result ? 'Успешно удалено.' : 'Ошибка удаления.',
        ])->setStatusCode(Response::HTTP_OK);
    }

}
