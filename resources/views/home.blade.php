@extends('layouts.admin.app')

@section('title')
    ค้นหาโครงงาน
@endsection

@section('header')
    ค้นหาโครงงาน
@endsection

@section('content')
    @include('search')
    <hr>
    @if ($isInit != true)
        ผลการค้นหาทั้งหมด {{ count($projects) }} รายการ

        @if (count($projects) == 0)
            <div class="row justify-content-center">
                <label>- ไม่พบข้อมูลโครงงาน -</label>
            </div>
        @endif
    @endif
    <div class="row justify-content-center">
        @foreach ($projects as $item)
            @php
                $students = [];
                $teachers = [];
                foreach ($item->relas as $rela) {
                    if ($rela->user->type == 0) {
                        array_push($students, $rela->user);
                    } else {
                        array_push($teachers, $rela->user);
                    }
                }
                $studentCount = count($students);
                $teacherCount = count($teachers);
            @endphp
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-body row">
                        <a href="{{ url('project/' . $item->id) }}" style="text-decoration: none;">
                            <div class="col-md-12">
                                {{ $item->name_th }}
                            </div>
                            <div class="col-md-12">
                                {{ $item->name_en }}
                            </div>
                        </a>
                        <div class="col-md-12">
                            <span>โดย : </span>
                            @foreach ($students as $key => $val)
                                @if ($key == $studentCount - 1)
                                    <span>
                                        {{ $val->fname }} {{ $val->lname }}
                                    </span>
                                @else
                                    <span>
                                        {{ $val->fname }} {{ $val->lname }},
                                    </span>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            <span>อาจารย์ที่ปรึกษาหลัก : </span>
                            @foreach ($teachers as $key => $val)
                                @if ($key == $teacherCount - 1)
                                    <span>
                                        {{ $val->fname }} {{ $val->lname }}
                                    </span>
                                @else
                                    <span>
                                        {{ $val->fname }} {{ $val->lname }},
                                    </span>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-12">
                            ปี : {{ $item->year + 543 }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#startYear').datepicker({
                format: 'yyyy',
                startView: "years",
                minViewMode: "years"
            });
            $('#endYear').datepicker({
                format: 'yyyy',
                startView: "years",
                minViewMode: "years",
            });
            $('#startYear').datepicker()
                .on('changeYear', function(e) {
                    // `e` here contains the extra attributes
                    var currYear = String(e.date).split(" ")[3];
                    $('#endYear').datepicker('update', '');
                    $('#endYear').datepicker('setStartDate', e.date);
                    console.log(currYear);
                });
        });

    </script>
@endpush
