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
    <label for="parent_id">Категории</label>
    <select id="parent_id" name="parent_id" class="custom-select">
        <option value="0">Родительская</option>
        @if ($categories->isNotEmpty())
            @foreach ($categories as $idx => $name)
                <option value="{{ $idx }}" @if (isset($item) && $item->parent_id == $idx) selected @endif>{{ $name }}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="mb-3">
    <label for="content" class="form-label">Контент</label>
    <textarea id="content" name="content" class="form-control @if (isset($errors)) @error('name') is-invalid @enderror @endif" rows="3" placeholder="Enter ...">{{ old('content')?? $item->content  ?? '' }}</textarea>
</div>
<div class="mb-3 form-check">
    <input id="is_active" name="is_active" value="@if (isset($item) && $item->is_active) 1 @else 0 @endif" type="checkbox" class="form-check-input" @if (isset($item) && $item->is_active == 1) checked @endif>
    <label class="form-check-label" for="is_active">Активность</label>
</div>
