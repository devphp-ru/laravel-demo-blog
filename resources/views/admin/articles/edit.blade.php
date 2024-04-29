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
                <div class="card-body">
                    <form action="{{ route('articles.update', $item) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.articles.components.form_field', [$item])
                        @include('admin.components.button.button_end', ['route' => 'articles.index'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script_js')
<script src="{{ asset('/assets/admin/js/script.js') }}"></script>
@endpush
