@extends('layouts.admin.app')

@section('title', 'USER MANAGEMENT')

@section('header', 'USER MANAGEMENT')


@section('content')

    <div class="row justify-content-between mx-auto my-2">
        <label for="student_table">ข้อมูลนักศึกษา</label>
        <span>
            <a href="{{ route('importExportView') }}" class="btn btn-warning">นำเข้า</a>
            <a href="{{ URL::to('admin/user/create') }}" class="btn btn-warning">เพิ่ม</a>
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>คำนำหน้า</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>E-mail</th>
                    <th>สถานะ</th>
                    <th class="text-center" style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key => $val)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $val->prefix->name }}</td>
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
            </tbody>
        </table>
    </div>
    <div class="row justify-content-between mx-auto my-2">
        <label for="teacher_table">ข้อมูลบุคลากร</label>
        <a href="{{ URL::to('admin/user/create') }}" class="btn btn-warning">เพิ่ม</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>คำนำหน้า</th>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>E-mail</th>
                    <th>สถานะ</th>
                    <th class="text-center" style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $key => $val)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $val->prefix->name }}</td>
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
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    ปิดการใช้งานผู้ใช้
                </div>
                <div class="modal-body">
                    ต้องการปิดการใช้งานผู้ใช้ใช่หรือไม่ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    {{-- /admin/user/id --}}
                    <form id="form" action="{{ url('/') }}" method="post">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger btn-ok" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#confirm-delete').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('userid')
                var username = button.data('username')
                var modal = $(this)
                modal.find('.modal-body').text('ต้องการปิดการใช้งาน Username : ' + username +
                    ' ใช่หรือไม่ ?')
                var action = $('#form').attr('action');
                $('#form').attr('action', action + '/admin/user/' + id)
                console.log(action);
                //form.action('admin/user'+id)
                //console.log(form);
                //footer.find('#form').href('admin/user/' + id + '')
            })
        });

    </script>
@endpush
