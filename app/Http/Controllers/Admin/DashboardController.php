<?php

namespace App\Http\Controllers\Admin;

use App\Services\ArticleComments\ArticleCommentService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends BaseController
{
    public function index(): View
    {
        $title = __('Панель управления');

        return view('admin.dashboards.index', [
            'title' => $title,
        ]);
    }

    public function articleComments(
        Request $request,
        ArticleCommentService $articleCommentService,
    ): View
    {
        $title = __('Комментарии к статьям');

        $perPage = 10;
        $articleComments = $articleCommentService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.dashboards.article_comments', [
            'title' => $title,
            'paginator' => $articleComments,
        ]);
    }

}
