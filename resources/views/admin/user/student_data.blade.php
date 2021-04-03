@foreach ($students as $key => $val)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $val->prefix->name ?? $val->name }}</td>
        <td>{{ $val->fname }}</td>
        <td>{{ $val->lname }}</td>
        <td>{{ $val->email }}</td>
        <td class="{{ $val->status == 1 ? 'text-success' : 'text-danger' }}">
            {{ $val->status == 1 ? 'Active' : 'Inactive' }}</td>
        <td class="text-right">
            <div class="row">
                <div class="col">
                    <a href="{{ url('admin/user/' . $val->id . '/edit') }}"
                        class="btn btn-success btn-block btn-sm"><i class="fas fa-edit"></i></a>
                </div>
                <div class="col">
                    <form id="form" action="{{ url('/admin/user/' . $val->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <button class="btn btn-primary btn-block btn-sm" type="submit"><i
                                class="fas fa-exchange-alt"></i></button>
                    </form>
                </div>
            </div>
        </td>
    </tr>
@endforeach
<tr>
    <td colspan="7" align="center" class="link">
        {{ $students->links() }}
    </td>
</tr>
