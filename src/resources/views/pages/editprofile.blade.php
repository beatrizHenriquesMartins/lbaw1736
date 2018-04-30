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
                        <div class = "photo col-sm-2">
                            <img border="0" alt="Photo"
                                 src="https://upload.wikimedia.org/wikipedia/commons/9/93/Shahter-Reak_M_2015_cropped_%2818%29.jpg"
                                 width="100" height="100">

                            <a href="#">
                                Edit Image
                            </a>
                        </div>

                        <form class = "form-horizontal" role="form" action="{{ route('editProfile') }}"" method="post">
                             {{ csrf_field() }}
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
                                    <div class = "col-sm-10">
                                        <div class = "form-group">
                                            <label class = "col-sm-2 control-label">
                                                First Name:
                                            </label>

                                            <div class = "col-sm-6">
                                                <input class="form-control" type="text" name="firstname">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class = "row">
                                    <div class = "col-sm-10">
                                        <div class = "form-group">
                                            <label class = "col-sm-2 control-label">
                                                Last Name:
                                            </label>

                                            <div class = "col-sm-6">
                                                <input class="form-control" type="text" name="lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class = "row">
                                    <div class = "col-sm-10">
                                        <div class = "form-group">
                                            <label class = "col-sm-2 control-label">
                                                Birthday:
                                            </label>

                                            <div class = "col-sm-6">
                                                <input class="form-control" type="date" name="birthday">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class = "row">
                                    <div class = "col-sm-10">
                                        <div class = "form-group">
                                            <label class = "col-sm-2 control-label">
                                                Email:
                                            </label>

                                            <div class = "col-sm-6">
                                                <input class="form-control" type="email" name="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class = "row">
                                    <div class = "col-sm-10">
                                        <div class = "form-group">
                                            <label class = "col-sm-2 control-label">
                                                NIF:
                                            </label>

                                            <div class = "col-sm-6">
                                                <input class="form-control" type="text" name="nif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--

                            <div class = "row addresses">
                                <p>
                                    Addresses:
                                </p>

                                <ul>
                                    <li class="row">
                                        <div class="col-xs-9">Rua Marco de Canaveses 19 Porto</div>

                                        <div class="col-xs-3">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="fa fa-remove">
                                                </span>
                                            </button>
                                        </div>
                                    </li>

                                    <li class="row">
                                         <div class="col-xs-9">Avenida 5 de Outubro 52 Lamego</div>

                                        <div class="col-xs-3">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="fa fa-remove">
                                                </span>
                                            </button>
                                        </div>
                                    </li>

                                    <li class="row">
                                        <div class="col-xs-9">
                                            Rua de Moçambique 138 Coimbra
                                        </div>

                                        <div class="col-xs-3">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="fa fa-remove">
                                                </span>
                                            </button>
                                        </div>
                                    </li>

                                    <li>
                                        <input type="text">
                                    </li>
                                </ul>
                            </div>
                        -->

                            <div class = "confirm_buttons row form-group">
                                <label class = "col-sm-0 control-label">
                                </label>

                                <div class = "col-sm-8">
                                    <input type="submit" class="btn btn-primary" value="Save">

                                    <span>
									</span>

                                    <input type="reset" class="btn btn-default" value="Cancel">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection