<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Вход</p>
            @if (session()->has('success'))
                <span class="text-success small">{{ session('success') }}</span>
            @endif
            @error('error')
            <span class="text-red small">{{ $message }}</span>
            @enderror
            <form action="{{ route('admin.login.handler') }}" method="post">
                @csrf
                @error('email')
                    <span class="text-red small">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input name="email" value="{{ old('email') ?? '' }}" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                    <span class="text-red small">{{ $message }}</span>
                @enderror
                <div class="input-group mb-3">
                    <input name="password" value="" type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Вход</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('/assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/admin/dist/js/adminlte.js') }}"></script>
</body>
</html>
