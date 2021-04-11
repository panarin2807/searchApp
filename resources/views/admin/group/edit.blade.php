@extends('layouts.admin.app')

@section('title')
    แก้ไขข้อมูลกลุ่ม
@endsection

@section('header')
    แก้ไขข้อมูลกลุ่ม
@endsection

@section('content')
    <div class="container">
        <form action="{{ $actionRoute }}" method="post">
            @csrf
            @method('put')
            @include('admin.group.form')
        </form>
    </div>
@endsection
