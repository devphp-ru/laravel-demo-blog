<tr>
    <td>{{ $value->id }}</td>
    <td>{{ $value->created_at->format('d.m.Y H:s') }}</td>
    <td><a href="{{ route('users.edit', $value) }}">{{ $value->name }}</a></td>
    <td>{{ $value->email }}</td>
    <td>{{ $value->articles->count() }}</td>
    <td>{{ $value->articleComments->count() }}</td>
    <td
        id="td{{ $value->id }}"
        data-id="{{ $value->id }}"
        data-table="users"
        data-field="is_banned"
        data-value="{{ $value->is_banned ? 0 : 1 }}"
        class="change-status"
        style="cursor:pointer"
        title="Изменить статус"
    >
        {{ $value->is_banned ? 'да' : 'нет' }}
    </td>
    <td>
        <a href="{{ route('users.edit', $value) }}" type="button" class="btn btn-block btn-primary btn-flat">Редактировать</a>
        <a href="{{ route('users.show', $value) }}" type="button" class="btn btn-block btn-info btn-flat">Профиль</a>
        <form action="{{ route('users.destroy', $value) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-block btn-danger" onclick="if(!confirm('Вы уверены, что хотите удалить?')) return false" title="Удалить">Удалить</button>
        </form>
    </td>
</tr>
