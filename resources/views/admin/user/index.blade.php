@extends('layouts.admin.app')

@section('title', 'USER MANAGEMENT')

@section('header', 'USER MANAGEMENT')


@section('content')

    <div class="row justify-content-between mx-auto my-2">
        <label for="student_table">ข้อมูลนักศึกษา</label>
        <a href="{{ URL::to('admin/user/create') }}" class="btn btn-primary">เพิ่ม</a>
    </div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>E-mail</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $val)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $val->fname }}</td>
                    <td>{{ $val->lname }}</td>
                    <td>{{ $val->email }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row justify-content-between mx-auto my-2">
        <label for="teacher_table">ข้อมูลบุคลากร</label>
        <a href="{{ URL::to('admin/user/create') }}" class="btn btn-primary">เพิ่ม</a>
    </div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>E-mail</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $key => $val)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $val->fname }}</td>
                    <td>{{ $val->lname }}</td>
                    <td>{{ $val->email }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
