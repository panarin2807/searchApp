@extends('layouts.app')

@section('content')
    <Form method="POST" id="form-id" action="{{ route('project.update', $project) }}" enctype="multipart/form-data">
        @csrf

        @method('PUT')

        <div class="form-group row">
            <label for="curr" class="col-md-4 col-form-label text-md-right">หลักสูตร : </label>
            <div class="col-md-6">
                <select name="curr" class="selectpicker form-control @error('curr') is-invalid @enderror"
                    title="เลือกหลักสูตร" data-live-search="true" data-size="5">
                    @foreach ($curr as $item)
                        <option value="{{ $item->id }}" @if ($project->curricula_id == $item->id) selected @endif>{{ $item->name }}</option>
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
            <label for="groups" class="col-md-4 col-form-label text-md-right">หมวดหมู่ : </label>
            <div class="col-md-6">
                <select name="group" data-size="5" class="selectpicker form-control @error('group') is-invalid @enderror"
                    title="เลือกหมวดหมู่" data-live-search="true">
                    @foreach ($groups as $item)
                        <option value="{{ $item->id }}" @if ($project->group_id == $item->id) selected @endif>{{ $item->name }}</option>
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
                    value="{{ $project->name_th ?? old('name_th') }}" autofocus>

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
                    value="{{ $project->name_en ?? old('name_en') }}" autofocus>

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
                <input id="datepicker" name="year" value="{{ $project->year + 543 }}"
                    class="form-control @error('year') is-invalid @enderror" autocomplete="off" />
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
                        data-selected-text-format="count > 3" data-live-search="true" data-size="5" multiple>
                        @foreach ($students as $item)
                            <option value="{{ $item->id }}" @foreach ($project->relas as $rela)  @if ($rela->user->id==$item->id)
                                selected @endif
                        @endforeach
                        >{{ $item->prefix->name }}{{ $item->fname }}
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
                        multiple data-size="5">
                        @foreach ($teachers as $item)
                            <option value="{{ $item->id }}" @foreach ($project->relas as $rela)  @if ($rela->user->id==$item->id)
                                selected @endif
                        @endforeach>{{ $item->prefix->name }}{{ $item->fname }}
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
                    class="form-control @error('abstract') is-invalid @enderror">{{ $project->abstract }}</textarea>
                @error('abstract')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        @foreach ($configs as $key => $item)
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">ส่วนที่ {{ $key + 1 }} : </label>
                <label class="col-md-2 col-form-label text-md-left">{{ $item->description }}</label>
                <div class="col-md-6">
                    <input type="file" accept="application/pdf" name="file_{{ $item->id }}" class="form-control-file">
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
                <a onclick="goBack()" class="btn btn-light">ยกเลิก</a>
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
        function goBack() {
            window.history.back();
        }
        $(document).ready(function() {
            var currentDate = new Date();
            currentDate.setYear(currentDate.getFullYear() + 543);

            $('#form-id').submit(function(event) {
                var selected = '';
                var input = $('#teacher_joint').find("option:selected");
                for (let index = 0; index < input.length; index++) {
                    const element = input[index];
                    if (index == input.length - 1) {
                        selected += element.text;
                    } else {
                        selected += element.text + ', ';
                    }
                }
                $('input[name=select_teacher_joint]').val(selected);
            });

            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#new_teacher').val("");
            })

            $('#add-teacher').on('click', function(e) {
                var text = $('#new_teacher').val();
                $("#teacher_joint").append('<option value="' + text + '" selected>' + text +
                    '</option>');
                $("#teacher_joint").selectpicker("refresh");
            });


            $('#datepicker').datepicker({
                format: 'yyyy',
                startView: "years",
                minViewMode: "years",
                defaultViewDate: currentDate,
                autoclose: true
            });
        })

    </script>
@endpush
