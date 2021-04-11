@extends('layouts.admin.app')

@section('title')
    เพิ่มข้อมูลหลักสูตร
@endsection

@section('header')
    เพิ่มข้อมูลหลักสูตร
@endsection

@section('content')
    <div class="container">
        <form action="{{ $actionRoute }}" method="post">
            @csrf
            @include('admin.curricular.form')
        </form>
    </div>
@endsection
