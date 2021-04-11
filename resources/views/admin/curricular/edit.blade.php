@extends('layouts.admin.app')

@section('title')
    แก้ไขข้อมูลหลักสูตร
@endsection

@section('header')
    แก้ไขข้อมูลหลักสูตร
@endsection

@section('content')
    <div class="container">
        <form action="{{ $actionRoute }}" method="post">
            @csrf
            @method('put')
            @include('admin.curricular.form')
        </form>
    </div>
@endsection
