{{-- @extends('layouts.app')

@section('content')
    <div>
        THIS USER IS INACTIVE.
    </div>
@endsection

<style>
    /* div {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-top: -100px;
        margin-left: -200px;
    } */

</style> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INACTIVE</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            color: #f8fafc;
            background-color: #212529;
        }

        /* div {
            height: 100%;
            width: 100%;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -135px;
            margin-top: -30px;
            font-size: 2em;
        } */

        .textCenter {
            height: 100%;
            width: 100%;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -135px;
            margin-top: -30px;
            font-size: 2em;
        }

        .textCenter2 {
            position: fixed;
            top: 55%;
            left: 50%;
            margin-left: -20px;
            margin-top: -10px;
        }

    </style>
</head>

<body>
    <div class="textCenter">
        THIS USER IS INACTIVE.
    </div>
    <div class="textCenter2">
        <a href="#" onclick="event.preventDefault();document.querySelector('#logout-form').submit();">LOGOUT</a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>

</html>
