<tr id="tr{{ $value->id }}">
    <td>{{ $value->id }}</td>
    <td>{{ $value->created_at->format('d.m.Y H:s') }}</td>
    <td>{{ $value->username }}<br><span class="small">{{ $value->email }}</span></td>
    <td>{{ $value->article->title }}</td>
    <td>{{ __($value->comment) }}</td>
    <td><span id="com{{ $value->id }}" data-id="{{ $value->id }}" data-value="{{ $value->is_active ? 0 : 1 }}" class="change-value" style="cursor:pointer" title="Изменить активность">{{ $value->is_active ? 'да' : 'нет' }}</span></td>
    <td><span data-id="{{ $value->id }}" class="delete-comment" style="cursor:pointer" onclick="if(!confirm('Вы уверены, что хотите удалить?')) return false" title="Удалить"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></span></td>
</tr>
