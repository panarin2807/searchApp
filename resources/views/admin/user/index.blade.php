@extends('layouts.admin.app')

@section('title', 'USER MANAGEMENT')

@section('header', 'USER MANAGEMENT')


@section('content')

    <input type="hidden" name="hidden_page" id="hidden_page" value="1">
    <div class="row justify-content-between mx-auto my-2">
        <label for="student_table">ข้อมูลนักศึกษา</label>
        <div class="input-group col-md-5">
            <input type="text" class="form-control mr-2" name="search" id="search" placeholder="พิมพ์ข้อความค้นหา">
            <div class="input-group-append">
                <a href="{{ route('importExportView') }}" class="btn btn-success mr-2">นำเข้า</a>
                <a href="{{ URL::to('admin/user/create') }}" class="btn btn-warning">เพิ่ม</a>
            </div>
        </div>
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
            <tbody id="user_body">
                @include('admin.user.student_data')
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
        function fetch_user(page, query) {
            $.ajax({
                url: '/admin/user/fetch_student?student=' + page + '&query=' + query,
                success: function(data) {
                    $('#user_body').html('')
                    $('#user_body').html(data)
                }
            })
        }

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
            })

            $('#search').on('keyup', function() {
                var query = $(this).val()
                var page = $('#hidden_page').val()
                page = 1
                fetch_user(page, query)
            })

            $(document).on('click', '.link nav a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('student=')[1];
                $('#hidden_page').val(page);
                var query = $('#search').val();

                console.log(page);

                // $('li').removeClass('active');
                // $(this).parent().addClass('active');
                fetch_user(page, query);
            });

        });

    </script>
@endpush
