@extends('admin.layouts.default')

@section('title', $title)

@section('breadcrumbs')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Главная</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin-users.create') }}" role="button" class="btn btn-primary btn-sm btn-flat">
                        Добавить
                    </a>
                    @if (request()->has('q'))
                        <a href="{{ route('admin-users.index') }}" role="button" class="btn btn-danger btn-sm btn-flat" title="Сбросить фильтр">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                        </a>
                    @endif
                    @if (request()->has('q') && !$paginator->isEmpty())
                        <span class="text-success">По запросу "{{ request()->input('q') }}" найдено</span>
                    @endif
                    @if (request()->has('q') && $paginator->isEmpty())
                        <span class="text-danger">По вашему запросу ничего не найдено</span>
                    @endif
                    <div class="pagination pagination-sm m-0 float-right">
                        <form action="{{ route('admin-users.index') }}" method="get">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input name="q" value="" type="text" class="form-control float-right" placeholder="Поиск..." autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Бан</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($paginator->isNotEmpty())
                            @foreach ($paginator as $value)
                                @include('admin.admin_users.components.tr_index', [$value])
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0">
                        {{ $paginator->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
