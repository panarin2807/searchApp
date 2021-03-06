@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col-md-4 mb-2">
            <input type="text" id="filter" class="form-control" placeholder="ค้นหา">
        </div>
    </div>
    <div id="show" class="row">
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
                        <a href="{{ route('project.edit', $item->id) }}" style="text-decoration: none;">
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
                    <div class="row justify-content-center">
                        <form id="form" action="{{ route('project.destroy', $item) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-end mt-4">
        <div class="col-md-2">
            {{ $projects->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#filter').on('keyup', function() {
                var value = $(this).val();
                $('#show div .card').filter(function() {
                    $(this).toggle($(this).text().indexOf(value) > -1)
                })
            });
        })

    </script>
@endpush
