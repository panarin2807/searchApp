@extends('layouts.admin.app')

@section('title')
    จัดการข้อมูลกลุ่ม
@endsection

@section('header')
    จัดการข้อมูลกลุ่ม
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-between mb-2">
            <div class="col-2"></div>
            <a href="{{ route('admin.group.create') }}" class="btn btn-primary">เพิ่ม</a>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>detail</th>
                            <th>status</th>
                            <th>management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->detail }}</td>
                                @if ($item->status == 1)
                                    <td class="text-success">Active</td>
                                @else
                                    <td class="text-danger">Inactive</td>
                                @endif
                                <td class="text-right">
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ url('admin/group/' . $item->id . '/edit') }}"
                                                class="btn btn-success btn-block btn-sm"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="col">
                                            <form id="form" action="{{ url('/admin/group/' . $item->id) }}" method="post">
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
                            <td colspan="5" class="text-center">{{ $groups->links() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
