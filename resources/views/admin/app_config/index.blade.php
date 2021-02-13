@extends('layouts.admin.app')

@section('title')
    APPLICATION CONFIG
@endsection

@section('header')
    APPLICATION CONFIG
@endsection

@section('content')
    <div class="table-responsive">
        <div class="row justify-content-between mx-auto my-2">
            <label>ตั้งค่าคำนำหน้า</label>
            <a href="{{ URL::to('admin/user/create') }}" class="btn btn-warning">เพิ่ม</a>
        </div>
        <table class="table table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prefixes as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{ url('admin/user/' . $item->id . '/edit') }}"
                                class="btn btn-success btn-block btn-sm"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
