<div class="mb-3">
    <label for="username" class="form-label">Имя</label>
    <input id="username" name="username" value="{{ old('username')?? $item->username  ?? '' }}" type="text" class="form-control @error('username') is-invalid @enderror" autocomplete="off">
    @error('username')
    <span class="text-red small">{{ $message }}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input id="email" name="email" value="{{ old('email')?? $item->email ?? '' }}" type="text" class="form-control @error('email') is-invalid @enderror" autocomplete="off">
    @error('email')
    <span class="text-red small">{{ $message }}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="password" class="form-label">Пароль</label>
    <input id="password" name="password" value="" type="text" class="form-control @error('password') is-invalid @enderror" autocomplete="off">
    @error('password')
    <span class="text-red small">{{ $message }}</span>
    @enderror
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Повторить пароль</label>
    <input id="password_confirmation" name="password_confirmation" value="" type="text" class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="off">
</div>
<div class="mb-3 form-check">
    <input id="is_banned" name="is_banned" value="@if (isset($item) && $item->is_banned == 1) 1 @else 0 @endif" type="checkbox" class="form-check-input" @if (isset($item) && $item->is_banned == 1) checked @endif>
    <label class="form-check-label" for="is_banned">Бан</label>
</div>
