<div class="mb-3">
    <label for="name" class="form-label">Название</label>
    <input id="name" name="name" value="{{ old('name')?? $item->name  ?? '' }}" type="text" class="form-control @if (isset($errors)) @error('name') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('name')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="content" class="form-label">Контент</label>
    <textarea id="content" name="content" class="form-control @if (isset($errors)) @error('content') is-invalid @enderror @endif" rows="3" placeholder="Enter ...">{{ old('content')?? $item->content  ?? '' }}</textarea>
</div>
<div class="mb-3 form-check">
    <input id="is_active" name="is_active" value="@if (isset($item) && $item->is_active) 1 @else 0 @endif" type="checkbox" class="form-check-input" @if (isset($item) && $item->is_active == 1) checked @endif>
    <label class="form-check-label" for="is_active">Активность</label>
</div>
