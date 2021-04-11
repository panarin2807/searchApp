@extends('layouts.admin.app')

@section('title')
    เพิ่มข้อมูลกลุ่ม
@endsection

@section('header')
    เพิ่มข้อมูลกลุ่ม
@endsection

@section('content')
    <div class="container">
        <form action="{{ $actionRoute }}" method="post">
            @csrf
            @include('admin.group.form')
        </form>
    </div>
@endsection
