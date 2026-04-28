<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ChangeStatusController extends Controller
{

    public function __invoke(Request $request): JsonResponse
    {
        $id = (int)$request->input('id');
        $table = $request->input('table');
        $field = $request->input('field');
        $value = (int)$request->input('value');

        $result = DB::table($table)->where('id', $id)->update([
            $field => $value,
        ]);

        return response()->json([
            'status' => $result ? 'success' : 'error',
            'id' => $id,
            'value' => $value === 1 ? 0 : 1,
        ])->setStatusCode($result ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }

}
