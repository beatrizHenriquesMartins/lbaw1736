@extends('layouts.main', ['type' => $type])
@section('content')

  <!-- breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="homepage.html">
                        Homepage
                    </a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    Profile
                </li>
            </ol>
        </nav>

        <div class="container-fluid main">
            <div class="row">
                <div class = "sidelinks col-sm-2">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active">
                            Profile
                        </a>

                        <a href="list_purchases.html" class="list-group-item list-group-item-action">
                            List of Purchases
                        </a>

                        <a href="list_favourites.html" class="list-group-item list-group-item-action">
                            List of Favourites
                        </a>
                    </div>
                </div>

                <div class = "user_area col-sm-8 col-sm-offset-1">
                    <div class = "row">
                        <form class = "form-horizontal" role="form" action="{{ route('editProfile') }}" method="post" enctype="multipart/form-data">
                           {{ csrf_field() }}

                            <div class = "photo col-sm-2">
                                <img border="0" alt="Photo" src="{{Auth::user()->imageurl}}" width="100" height="100">
                                <input id="imageUpload" type="file" name="imageurl" placeholder="Photo" capture>
                                  @if ($errors->has('imageurl'))
                                    <span class="error">
                                      {{ $errors->first('imageurl') }}
                                    </span>
                                  @endif
                            </div>
                            <div class = "information col-sm-10 col-xs-10">
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "Username">
                                                     Username:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <p class = "username-input">
                                                    {{ Auth::user()->username }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "FirstName">
                                                    Firts Name:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <input class="form-control" type="text" name="firstname" @if(old('firstname'))value="{{old('firstname')}}"@endif>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('firstname'))
                                      <span class="error">
                                        {{ $errors->first('firstname') }}
                                      </span>
                                    @endif
                                </div>
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "LastName">
                                                    Last Name:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <input class="form-control" type="text" name="lastname" @if(old('lastname'))value="{{old('lastname')}}"@endif>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('lastname'))
                                      <span class="error">
                                        {{ $errors->first('lastname') }}
                                      </span>
                                    @endif
                                </div>
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "Birthday">
                                                    Birthday:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <input class="form-control" type="date" name="birthday" @if(old('birthday'))value="{{old('birthday')}}"@endif>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('birthday'))
                                      <span class="error">
                                        {{ $errors->first('birthday') }}
                                      </span>
                                    @endif
                                </div>
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "Password">
                                                    Password:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <input type="password" class="form-control" name="password" id="password" autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                      <span class="error">
                                        {{ $errors->first('password') }}
                                      </span>
                                    @endif
                                </div>
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "Password">
                                                    Confirm Password:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                              <input type="password" class="form-control" name="password_confirmation" id="confirm" autofocus>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-sm-10 col-xs-10">
                                        <div class = "row">
                                            <div class = "col-sm-2 col-xs-2 ">
                                                <p class = "Email">
                                                    Email:
                                                </p>
                                            </div>

                                            <div class = "col-sm-10 col-xs-10">
                                                <p class = "email-input">
                                                    {{ Auth::user()->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "confirm_buttons row form-group">
                                <label class = "col-sm-0 control-label">
                                </label>

                                <div class = "col-sm-8">
                                    <button type="submit" class="btn btn-primary"> Save </button>
                                    <span>
                                    </span>

                                    <a role="button" href="{{ url('/profile') }}" class="btn btn-default"> Cancel </a>
                                </div>
                            </div>
                        </form>



                        <div class = "row addresses">
                            <p>
                                Addresses:
                            </p>

                            <ul>
                                @each('partials.address', $addresses, 'address')
                            </ul>

                            <li class="addAddress">
                                <input class="street" type="text" name="street" placeholder="Street">
                                <input class="zipcode" type="text" name="zipcode" placeholder="Zip Code">
                                <input class="city" type="text" name="city" placeholder="City">
                                <input class="country" type="text" name="country" placeholder="Country">
                                <a role="button" class="btn btn-primary"> Add </a>

                            </li>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
