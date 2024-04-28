<tr>
    <td>{{ $value->id }}</td>
    <td>{{ $value->created_at->format('d.m.Y H:s') }}</td>
    <td><a href="{{ route('categories.edit', $value) }}">{{ $value->name }}</a></td>
    <td>{{ $value->parent?->name }}</td>
    <td>{{ 0 }}</td>
    <td>{{ $value->is_active ? 'да' : 'нет' }}</td>
    <td>
        <a href="{{ route('categories.edit', $value) }}" type="button" class="btn btn-block btn-primary btn-flat">Редактировать</a>
        <form action="{{ route('categories.destroy', $value) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-block btn-danger" onclick="if(!confirm('Вы уверены, что хотите удалить?')) return false" title="Удалить">Удалить</button>
        </form>
    </td>
</tr>
