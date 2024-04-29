<div class="mb-3">
    <label for="category_id">Категории</label>
    <select id="category_id" name="category_id" class="custom-select">
        @if ($categories->isNotEmpty())
            @foreach ($categories as $idx => $name)
                <option value="{{ $idx }}" @if (isset($item) && $item->category_id == $idx) selected @endif>{{ $name }}</option>
            @endforeach
        @endif
    </select>
    @if (isset($errors))
        @error('category_id')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
@if ($tags->isNotEmpty())
<div class="mb-3">
    <label>Тэги</label>
    <select id="tags" name="tags[]" class="select2 custom-select" multiple="" data-placeholder="Select a State" tabindex="-1" aria-hidden="true">
        @foreach ($tags as $idx => $name)
            <option value="{{ $idx }}" @if (isset($item) && in_array($idx, $item->tags->pluck('id')->toArray())) selected @endif>{{ $name }}</option>
        @endforeach
    </select>
</div>
@endif
<div class="mb-3">
    <label for="title" class="form-label">Название</label>
    <input id="title" name="title" value="{{ old('title')?? $item->title  ?? '' }}" type="text" class="form-control @if (isset($errors)) @error('title') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('title')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="content" class="form-label">Контент</label>
    <textarea id="content" name="content" class="form-control @if (isset($errors)) @error('content') is-invalid @enderror @endif" rows="3" placeholder="Enter ...">{{ old('content')?? $item->content  ?? '' }}</textarea>
    @if (isset($errors))
        @error('content')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3">
    <label for="views" class="form-label">Просмотров</label>
    <input id="views" name="views" value="{{ old('views')?? $item->views  ?? 0 }}" type="text" class="form-control @if (isset($errors)) @error('views') is-invalid @enderror @endif" autocomplete="off">
    @if (isset($errors))
        @error('views')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="mb-3 form-check">
    <input id="is_active" name="is_active" value="@if (isset($item) && $item->is_active) 1 @else 0 @endif" type="checkbox" class="form-check-input @if (isset($errors)) @error('is_active') is-invalid @enderror @endif" @if (isset($item) && $item->is_active == 1) checked @endif>
    <label class="form-check-label" for="is_active">Активность</label>
    @if (isset($errors))
        @error('is_active')
        <span class="text-red small">{{ $message }}</span>
        @enderror
    @endif
</div>
<div class="input-group mb-3">
    <input id="image" name="image" type="file" class="form-control @if (isset($errors)) @error('image') is-invalid @enderror @endif">
    <label class="input-group-text" for="image">Изображение</label>
</div>
@if (isset($errors))
    @error('image')
    <span class="text-red small">{{ $message }}</span>
    @enderror
@endif
@if (isset($item) && $item->thumbnail)
    <div class="card" style="width: 18rem;">
        <img src="{{ asset($item->thumbnail) }}" class="img-thumbnail" alt="...">
    </div>
@endif
