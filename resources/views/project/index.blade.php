@extends('layouts.admin.app')

@section('tiitle', 'SHOW PROJECT')

@section('header', 'SHOW PROJECT')

@section('content')
    @foreach ($projects as $val)
        <div>
            {{ $val->group->name }}
        </div>
    @endforeach
@endsection
