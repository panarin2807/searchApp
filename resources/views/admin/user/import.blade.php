@extends('layouts.admin.app')

@section('title')
    Import Users
@endsection

@section('header')
    Import Users
@endsection

@section('content')
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success">Import User Data</button>
    </form>
@endsection
