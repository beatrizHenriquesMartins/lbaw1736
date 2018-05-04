@extends('layouts.signin_register')

@section('content')
    <div class="register-container container">
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
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div id="form_name" class="form-group">
                        <label for="name" class="cols-sm-2 control-label">
                            First Name
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="firstname" id="name"
                                       @if(old('firstname'))value="{{old('firstname')}}"@endif required autofocus>
                            </div>
                        </div>

                        @if ($errors->has('name'))
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>

                    <div id="form_name" class="form-group">
                        <label for="name" class="cols-sm-2 control-label">
                            Last Name
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="lastname" id="name"
                                       @if(old('firstname'))value="{{old('lastname')}}"@endif required autofocus>
                            </div>
                        </div>

                        @if ($errors->has('name'))
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>


                    <div id="form_email" class="form-group">
                        <label for="email" class="cols-sm-2 control-label">
                            Email
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="email" id="email"
                                       @if(old('email'))value="{{old('email')}}"@endif required autofocus>
                            </div>
                        </div>

                        @if ($errors->has('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div id="form_username" class="form-group">
                        <label for="username" class="cols-sm-2 control-label">
                            Username
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="username" id="username"
                                       @if(old('username'))value="{{old('username')}}"@endif autofocus>
                            </div>
                        </div>

                        @if ($errors->has('username'))
                            <span class="error">
                                {{ $errors->first('username') }}
                            </span>
                        @endif
                    </div>

                    <div id="form_cellphone" class="form-group">
                        <label for="cellphone" class="cols-sm-2 control-label">
                            Cellphone
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-phone fa" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="text" class="form-control" name="cellphone" id="cellphone"
                                       @if(old('cellphone'))value="{{old('cellphone')}}"@endif required autofocus>
                            </div>
                        </div>

                        @if ($errors->has('cellphone'))
                            <span class="error">
                                {{ $errors->first('cellphone') }}
                            </span>
                        @endif
                    </div>

                    <div id="form_password" class="form-group">
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
                                       required autofocus>
                            </div>
                        </div>

                        @if ($errors->has('password'))
                            <span class="error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>

                    <div id="form_confirmPassword" class="form-group">
                        <label for="confirm" class="cols-sm-2 control-label">
                            Confirm Password
                        </label>

                        <div class="cols-sm-10">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock fa-lg" aria-hidden="true">
                                    </i>
                                </span>

                                <input type="password" class="form-control" name="password_confirmation" id="confirm"
                                       required autofocus>
                            </div>
                        </div>
                    </div>


                    <div id="form_button" class="form-group ">
                        <button type="submit" class="btn btn-success btn-lg btn-block login-button">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
