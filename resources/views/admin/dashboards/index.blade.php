@extends('admin.layouts.default')

@section('title', $title)

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
     @include('admin.dashboards.components.small_box')
    </div>

    <div class="row">
        <section class="col-lg-7 connectedSortable">

        </section>

    </div>
@endsection
