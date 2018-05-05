@extends('layouts.signin_register')

@section('content')
    <div class="login-container container d-sm-flex">
        <div class="row main">
            <div class="panel-heading">
                <div class="text-center mb-4">
                    <!-- tamanho logo 1375 x 312 -->
                    <a href="{{ url('/homepage') }}">
                        <img class="mb-4" src="./images/logo_1.png" alt="logo" width="323.75" height="78">
                    </a>
                </div>
            </div>

            <div class="main-login main-center">
                <form class="form-horizontal" method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div id="form_username" class="form-group">
                        <label for="username" class="cols-sm-2 control-label">
                            Email
                        </label>

                        <div id="form_password" class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="email" id="username"
                                       @if(old('email'))value="{{old('email')}}"@endif required autofocus/>
                            </div>
                        </div>

                        @if ($errors->has('email'))
                            <span id="credencial_error" class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password" class="cols-sm-2 control-label">
                            Password
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock fa-lg" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="password" class="form-control" name="password" id="password"
                                       required autofocus/>
                            </div>
                        </div>

                        @if ($errors->has('password'))
                            <span id="credencial_error" class="error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>

                    <div id="btn_logIn" class="form-group ">
                        <button type="submit" class="btn btn-success btn-lg btn-block login-button">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
