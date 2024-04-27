<tr>
    <td>{{ $value->id }}</td>
    <td>{{ $value->created_at->format('d.m.Y H:s') }}</td>
    <td><a href="{{ route('users.edit', $value) }}">{{ $value->name }}</a></td>
    <td>{{ $value->email }}</td>
    <td>{{ $value->is_banned ? 'да' : 'нет' }}</td>
    <td>
        <a href="{{ route('users.edit', $value) }}" type="button" class="btn btn-block btn-primary btn-flat">Редактировать</a>
        <form action="{{ route('users.destroy', $value) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-block btn-danger" onclick="if(!confirm('Вы уверены, что хотите удалить?')) return false" title="Удалить">Удалить</button>
        </form>
    </td>
</tr>
