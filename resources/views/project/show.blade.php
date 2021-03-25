@extends('layouts.admin.app')

@php
$studentCount = 0;
$teacherCount = 0;
@endphp

@section('tiitle', 'SHOW PROJECT')

@section('header', 'SHOW PROJECT')

@section('content')
    <div class="row pl-4">
        <div class="col-3">
            ชื่อภาษาไทย :
        </div>
        <div class="col-9">
            {{ $project->name_th }}
        </div>
        <div class="col-3">
            ชื่อภาษาอังกฤษ :
        </div>
        <div class="col-9">
            {{ $project->name_en }}
        </div>
        <div class="col-3">
            ปีการศึกษา :
        </div>
        <div class="col-9">
            {{ $project->year }}
        </div>
        @foreach ($project->relas as $rela)
            @if ($rela->user->type == 0)
                @php
                    $studentCount++;
                @endphp
                <div class="col-3">
                    นักศึกษาคนที่ {{ $studentCount }} :
                </div>
                <div class="col-9">
                    {{ $rela->user->prefix->name }}{{ $rela->user->fname }} {{ $rela->user->lname }}
                </div>
            @endif
        @endforeach
        @foreach ($project->relas as $rela)
            @if ($rela->user->type != 0)
                @php
                    $teacherCount++;
                @endphp
                <div class="col-3">
                    อาจารย์ที่ปรึกษาหลัก :
                </div>
                <div class="col-9">
                    {{ $rela->user->prefix->name }}{{ $rela->user->fname }} {{ $rela->user->lname }}
                </div>
            @endif
        @endforeach
        <div class="col-3">
            อาจารย์ที่ปรึกษาร่วม :
        </div>
        <div class="col-9">
            {{ $project->advisor_joint }}
        </div>
        {{-- <div class="col-3">
            Fulltext :
        </div>
        <div class="col-9">
            <a href="#" id="show-full-text">กดเพื่อแสดง Fulltext</a>
        </div> --}}
        <div class="col-3"></div>
        <div class="col-9" id="fulltext" style="display: none">
            <a href="#">ส่วนหน้า</a><br />
            <a href="#">บทที่ 1</a><br />
            <a href="#">บทที่ 2</a><br />
            <a href="#">บทที่ 3</a><br />
            <a href="#">บทที่ 4</a><br />
            <a href="#">บทที่ 5</a><br />
            <a href="#">ส่วนอ้างอิง</a><br />
        </div>
        <div class="col-12"></div>
        <div class="col-3">บทคัดย่อ :</div>
        <div class="col">{{ $project->abstract }}</div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Format</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project->files as $key => $file)
                    @if ($file->config->status == 1)
                        <tr>
                            <td>
                                {{ pathinfo($file->value, PATHINFO_FILENAME) }}
                            </td>
                            <td>
                                {{ $file->config->description }}
                            </td>
                            <td>
                                @php
                                    if (Storage::disk('public')->exists($file->value)) {
                                        $size = Storage::disk('public')->size($file->value) / 1000;
                                        if ($size >= 1000) {
                                            $size = $size / 1000;
                                            echo round($size, 2) . ' MB';
                                        } else {
                                            echo round($size, 2) . ' kB';
                                        }
                                    } else {
                                        echo '0 B';
                                    }
                                @endphp
                            </td>
                            <td>
                                {{ pathinfo($file->value, PATHINFO_EXTENSION) }}
                            </td>
                            <td>
                                @if (Storage::disk('public')->exists($file->value))
                                    <a target="_blank" href="{{ asset('storage/'.$file->value) }}" class="btn btn-primary">View</a>
                                @else
                                    <button class="btn btn-primary" disabled>View</button>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Format</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        หน้าปก บทคัดย่อ และสารบัญ
                    </td>
                    <td>
         
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        บทที่ 1
                    </td>
                    <td>
                       
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        บทที่ 2
                    </td>
                    <td>
                       
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        บทที่ 3
                    </td>
                    <td>
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        บทที่ 4
                    </td>
                    <td>
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        บทที่ 5
                    </td>
                    <td>
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_FILENAME) }}
                    </td>
                    <td>
                        รายการอ้างอิงและภาคผนวก
                    </td>
                    <td>
                        
                        @php
                            echo Storage::size($project->file_front).' B';
                        @endphp
                    </td>
                    <td>
                        {{ pathinfo($project->file_front, PATHINFO_EXTENSION) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div> --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#show-full-text').on('click', function() {
                $('#fulltext').toggle('slow')
            })
        });

    </script>
@endpush
