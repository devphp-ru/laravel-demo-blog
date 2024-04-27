<div class="mb-3">
    <label for="name" class="form-label">Имя</label>
    <input id="name" name="name" value="{{ old('name')?? $item->name  ?? '' }}" type="text" class="form-control @if (isset($errors)) @error('name') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('name')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input id="email" name="email" value="{{ old('email')?? $item->email ?? '' }}" type="text" class="form-control  @if (isset($errors)) @error('email') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('email')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="password" class="form-label">Пароль</label>
    <input id="password" name="password" value="" type="text" class="form-control @if (isset($errors)) @error('password') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('password')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Повторить пароль</label>
    <input id="password_confirmation" name="password_confirmation" value="" type="text" class="form-control" autocomplete="off">
</div>
<div class="mb-3 form-check">
    <input id="is_banned" name="is_banned" value="@if (isset($item) && $item->is_banned == 1) 1 @else 0 @endif" type="checkbox" class="form-check-input" @if (isset($item) && $item->is_banned == 1) checked @endif>
    <label class="form-check-label" for="is_banned">Бан</label>
</div>
