@extends('layouts.admin.app')

@section('title', 'ACCOUNT SETTING')

@section('header', 'ACCOUNT SETTING')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    {{ method_field('PUT') }}

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">คำนำหน้า : </label>
                        <div class="col-md-6">
                            <select name="prefix" class="form-control @error('prefix') is-invalid @enderror">
                                @foreach ($prefixes as $key => $item)
                                    @if ($item->id == $user->prefix->id)
                                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                        <div class="col-md-6">
                            <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                name="fname" value="{{ old('fname') ?? $user->fname }}" required autofocus>

                            @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                        <div class="col-md-6">
                            <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                name="lname" value="{{ old('lname') ?? $user->lname }}" required autofocus>

                            @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                autocomplete="new-password">
                        </div>
                    </div>

                    <div class="container">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            <a href="{{ route('home') }}" class="btn btn-ligth">กลับ</a>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
