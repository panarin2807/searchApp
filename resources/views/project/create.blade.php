@extends('layouts.admin.app')

@section('title')
    CREATE PROJECT
@endsection

@section('header')
    CREATE PROJECT
@endsection

@section('content')
    <Form method="POST" id="form-id" onsubmit="return validateFile()" action="{{ route('project.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="curr" class="col-md-4 col-form-label text-md-right">หลักสูตร : </label>
            <div class="col-md-6">
                <select name="curr" class="selectpicker form-control @error('curr') is-invalid @enderror"
                    title="เลือกหลักสูตร" data-live-search="true">
                    @foreach ($curr as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('curr')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="groups" class="col-md-4 col-form-label text-md-right">กลุ่ม : </label>
            <div class="col-md-6">
                <select name="group" class="selectpicker form-control @error('group') is-invalid @enderror"
                    title="เลือกกลุ่ม" data-live-search="true">
                    @foreach ($groups as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('group')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="name_th" class="col-md-4 col-form-label text-md-right">ชื่อโครงงานภาษาไทย : </label>

            <div class="col-md-6">
                <input id="name_th" type="text" class="form-control @error('name_th') is-invalid @enderror" name="name_th"
                    value="{{ old('name_th') }}" autofocus>

                @error('name_th')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="name_en" class="col-md-4 col-form-label text-md-right">ชื่อโครงงานภาษาอังกฤษ : </label>

            <div class="col-md-6">
                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                    value="{{ old('name_en') }}" autofocus>

                @error('name_en')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">ปีการศึกษา : </label>
            <div class="col-md-6">
                <input id="datepicker" name="year" class="form-control @error('year') is-invalid @enderror" />
                @error('year')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="student-container">
            <div class="form-group row">
                <label for="student" class="col-md-4 col-form-label text-md-right">นักศึกษา : </label>
                <div class="col-md-6">
                    <select name="student[]" id="student"
                        class="selectpicker form-control @error('student') is-invalid @enderror" title="เลือกนักศึกษา"
                        data-selected-text-format="count > 3" data-live-search="true" multiple>
                        @foreach ($students as $item)
                            <option value="{{ $item->id }}">{{ $item->prefix->name }}{{ $item->fname }}
                                {{ $item->lname }}</option>
                        @endforeach
                    </select>
                    @error('student')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="teacher-container">
            <div class="form-group row">
                <label for="teacher" class="col-md-4 col-form-label text-md-right">อาจารย์ที่ปรึกษาหลัก : </label>
                <div class="col-md-6">
                    <select name="teacher[]" id="teacher"
                        class="selectpicker form-control @error('teacher') is-invalid @enderror"
                        title="เลือกอาจารย์ที่ปรึกษาหลัก" data-selected-text-format="count > 3" data-live-search="true"
                        multiple>
                        @foreach ($teachers as $item)
                            <option value="{{ $item->id }}">{{ $item->prefix->name }}{{ $item->fname }}
                                {{ $item->lname }}</option>
                        @endforeach
                    </select>
                    @error('teacher')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <input type="hidden" id="select_teacher_joint" name="select_teacher_joint">

        <div class="teacher-joint-container">
            <div class="form-group row">
                <label for="teacher-joint" class="col-md-4 col-form-label text-md-right">ที่ปรึกษาร่วม : </label>
                <div class="col-md-6">
                    <select name="teacher_joint[]" id="teacher_joint" class="selectpicker form-control"
                        title="เลือกที่ปรึกษาร่วม" data-selected-text-format="count > 3" data-live-search="true" multiple>
                        @foreach ($teachers as $item)
                            <option value="{{ $item->id }}">{{ $item->prefix->name }}{{ $item->fname }}
                                {{ $item->lname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">เพิ่ม</a>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-md-4 col-form-label text-md-right">บทคัดย่อ : </label>
            <div class="col-md-6">
                <textarea name="abstract" style="resize:none;" rows="5"
                    class="form-control @error('abstract') is-invalid @enderror"></textarea>
                @error('abstract')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        @foreach ($configs as $key => $item)
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-md-right">ส่วนที่ {{ $key + 1 }} : </label>
                <label class="col-md-2 col-form-label text-md-left">{{ $item->description }}</label>
                <div class="col-md-6">
                    <input type="file" accept="application/pdf" name="file_{{ $item->id }}"
                        class="form-control-file" required>
                    @error('file_{{ $item->id }}')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        @endforeach

        <div class="container">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success">บันทึก</button>
                <a href="{{ route('home') }}" class="btn btn-ligth">ยกเลิก</a>
            </div>
        </div>
    </Form>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">เพิ่มที่ปรึกษาใหม่</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" name="new_teacher" id="new_teacher" class="form-control" autofocus>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">ปิด</button>
                <button type="button" id="add-teacher" class="btn btn-primary" data-dismiss="modal">บันทึก</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function validateFile() {
            $(document).ready(function() {
                var selected = [];
                var input = $('#teacher_joint').find("option:selected");
                for (let index = 0; index < input.length; index++) {
                    const element = input[index];
                    selected.push(element.text);
                }
                console.log(selected);
                $('#select_teacher_joint').val(selected);
            })
            return true;
        }

        function submitForm(frm) {
            $(document).ready(function() {
                var selected = [];
                var input = $('#teacher_joint').find("option:selected");
                for (let index = 0; index < input.length; index++) {
                    const element = input[index];
                    selected.push(element.text);
                }
                console.log(selected);
                $('#select_teacher_joint').val(selected);
                frm.submit();
            })
        }

        $(document).ready(function() {

            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#new_teacher').val("");
            })

            $('#add-teacher').on('click', function(e) {
                var text = $('#new_teacher').val();
                $("#teacher_joint").append('<option value="' + text + '" selected>' + text +
                    '</option>');
                $("#teacher_joint").selectpicker("refresh");
            });

            // $('#teacher_joint').change(function() {
            //     var selected = [];
            //     var input = $(this).find("option:selected");
            //     for (let index = 0; index < input.length; index++) {
            //         const element = input[index];
            //         selected.push(element.text);
            //     }
            //     $('#select_teacher_joint').val(selected);
            // });

            $('#datepicker').datepicker({
                format: 'yyyy',
                startView: "years",
                minViewMode: "years"
            });

            // var wrapperStudent = $('.student-container')
            // var addStudentButton = $('#add-student')
            // var limitStudent = Number('<?php echo count($students); ?>');
            // var countStudent = 1;
            // var students = JSON.parse('<?php echo json_encode($students); ?>');
            // var studentOption = '';

            // var wrapperTeacher = $('.teacher-container')
            // var addTeacherButton = $('#add-teacher')
            // var limitTeacher = Number('<?php echo count($teachers); ?>');
            // var countTeacher = 1;
            // var teachers = JSON.parse('<?php echo json_encode($teachers); ?>');
            // var teacherOption = '';

            // var wrapperTeacherJoint = $('.teacher-joint-container');
            // var addTeacherJointButton = $('#add-teacher-joint');

            // students.forEach(element => {
            //     studentOption += '<option value="' + element.id + '">' + element.fname + ' ' + element
            //         .lname + '</option>';
            // });

            // teachers.forEach(element => {
            //     teacherOption += '<option value="' + element.id + '">' + element.fname + ' ' + element
            //         .lname + '</option>';
            // });

            // $(addTeacherJointButton).click(function(e) {
            //     e.preventDefault();
            //     $(wrapperTeacherJoint).append(
            //         '<div class="form-group row">' +
            //         '<div class="col-md-4"></div>' +
            //         '<div class="col-md-6">' +
            //         '<select name="teacher_joint[]" required class="form-control ">' +
            //         '<option value="">เลือกอาจารย์ที่ปรึกษาร่วม</option>' +
            //         teacherOption +
            //         '</select>' +
            //         '</div>' +
            //         '<div class="col-md-1">' +
            //         '<a href="#" class="btn btn-danger mr-2 delete-teacher-joint">ลบ</a>' +
            //         '</div>' +
            //         '</div>')
            // });

            // $(wrapperTeacherJoint).on("click", ".delete-teacher-joint", function(e) {
            //     e.preventDefault();
            //     var div = $(this).parent('div');
            //     div.parent('div').remove();
            // })

            // $(addTeacherButton).click(function(e) {
            //     e.preventDefault();
            //     if (countTeacher < limitTeacher) {
            //         countTeacher++
            //         $(wrapperTeacher).append(
            //             '<div class="form-group row">' +
            //             '<div class="col-md-4"></div>' +
            //             '<div class="col-md-6">' +
            //             '<select name="users[]" required class="form-control ">' +
            //             '<option value="">เลือกอาจารย์</option>' +
            //             teacherOption +
            //             '</select>' +
            //             '</div>' +
            //             '<div class="col-md-1">' +
            //             '<a href="#" class="btn btn-danger mr-2 delete-teacher">ลบ</a>' +
            //             '</div>' +
            //             '</div>')
            //     } else {
            //         alert('ไม่สามารถเพิ่มอาจารย์ได้')
            //     }

            // });

            // $(wrapperTeacher).on("click", ".delete-teacher", function(e) {
            //     e.preventDefault();
            //     var div = $(this).parent('div');
            //     div.parent('div').remove();
            //     countTeacher--
            // })

            // $(addStudentButton).click(function(e) {
            //     e.preventDefault();
            //     if (countStudent < limitStudent) {
            //         countStudent++
            //         $(wrapperStudent).append(
            //             '<div class="form-group row">' +
            //             '<div class="col-md-4"></div>' +
            //             '<div class="col-md-6">' +
            //             '<select name="users[]" required class="form-control ">' +
            //             '<option value="">เลือกนักศึกษา</option>' +
            //             studentOption +
            //             '</select>' +
            //             '</div>' +
            //             '<div class="col-md-1">' +
            //             '<a href="#" class="btn btn-danger mr-2 delete-student">ลบ</a>' +
            //             '</div>' +
            //             '</div>')
            //     } else {
            //         alert('ไม่สามารถเพิ่มนักศึกษาได้')
            //     }

            // });

            // $(wrapperStudent).on("click", ".delete-student", function(e) {
            //     e.preventDefault();
            //     var div = $(this).parent('div');
            //     div.parent('div').remove();
            //     countStudent--
            // })

            // $('#submit').click(function(e) {
            //     e.preventDefault();
            //     //alert('submit')
            //     // var k = "The respective values are :";
            //     // var input = document.getElementsByName('users[]');
            //     // var selected = [];
            //     // for (var i = 0; i < input.length; i++) {
            //     //     selected.push(input[i].value);
            //     // }
            //     // selected = selected.filter(function(item, pos) {
            //     //     return selected.indexOf(item) == pos && item != "";
            //     // })
            //     // if (selected.length > 0) {
            //     //     var xhr = new XMLHttpRequest();
            //     //     xhr.open("POST", '<?php echo url('project/store'); ?>', true);
            //     //     xhr.setRequestHeader('Content-Type', 'application/json');
            //     //     xhr.send(JSON.stringify({
            //     //         name_th : "",
            //     //         name_en : "",
            //     //         users : selected
            //     //     }));
            //     // }else{
            //     //     alert('กรุณาเลือกนักศึกษา / อาจารย์ที่ปรึกษา')
            //     // }
            //     //$('form').submit()
            //     //document.getElementById("form-id").submit()
            // })
        });

    </script>
@endpush
