@extends('layouts.main', ['type' => $type])
@section('content')
    @if($type == 2)
    <div class="edit">
        <a href="{{ route('showEditProfile', ['id' => $user->id]) }}">
            <i class="fa fa-edit">
            </i>
        </a>
    </div>
    @endif

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
                        <a href="{{ route('profile') }}" class="list-group-item list-group-item-action active">
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
                        </div>

                        <div class = "information col-sm-8 col-xs-9">
                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p class = "Username">
                                                Username:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p class = "username-input">
                                                {{ Auth::user()->username }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p>
                                               Name:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p>
                                                {{ Auth::user()->firstname ." ". Auth::user()->lastname }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p >
                                                Age:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p >
                                                Isto ainda nao está:
                                                33
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p>
                                                Birthday:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p >
                                                Isto ainda nao está:
                                                5/02/1985
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p>
                                                Email:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p >
                                                 {{ Auth::user()->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-sm-9">
                                    <div class = "row">
                                        <div class = "col-sm-2">
                                            <p >
                                                NIF:
                                            </p>
                                        </div>

                                        <div class = "col-sm-10">
                                            <p >
                                                {{ Auth::user()->nif }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class = "col-sm-1 col-xs-2">
                            

                            <a href="{{route('showEditProfile')}}" role="button">
                                <button type="button" class="btn btn-default btn-sm glyphicon glyphicon-edit" role="button">
                                    Edit
                                </button>
                            </a>
                            
                        </div>
                    </div>

                    <div class = "row addresses">
                        <p>
                            Addresses:
                        </p>

                        <ul>
                            <li>
                                Isto ainda nao está:
                                Rua Marco de Canaveses 19 Porto
                            </li>

                            <li>
                                Avenida 5 de Outubro 52 Lamego
                            </li>

                            <li>
                                Rua de Moçambique 138 Coimbra
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection