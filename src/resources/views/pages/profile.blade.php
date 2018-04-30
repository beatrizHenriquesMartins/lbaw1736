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
                @if(!isset($page))
                  <li class="breadcrumb-item" aria-current="page">
                      Profile
                  </li>
                @endif
                @if(isset($page))
                  <li class="breadcrumb-item" aria-current="page">
                      User Profile
                  </li>
                @endif
            </ol>
        </nav>

        <div class="container-fluid main">
            <div class="row">
                <div class = "sidelinks col-sm-2">
                    <div class="list-group">

                        @if(!isset($page))
                          <a href="{{ route('profile') }}" class="list-group-item list-group-item-action active">
                              Profile
                          </a>

                          <a href="list_purchases.html" class="list-group-item list-group-item-action">
                              List of Purchases
                          </a>

                          <a href="list_favourites.html" class="list-group-item list-group-item-action">
                              List of Favourites
                          </a>
                        @endif
                        @if(isset($page))
                          <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                              Profile
                          </a>

                          <a href="/clients" class="list-group-item list-group-item-action">
                              List of Clients
                          </a>

                          <a href="/bms" class="list-group-item list-group-item-action">
                              List of Brand Managers
                          </a>

                          <a href="/supports" class="list-group-item list-group-item-action">
                              List of SupportChat
                          </a>
                          <a href="/bans" class="list-group-item list-group-item-action">
                              List of Banned Users
                          </a>
                        @endif
                    </div>
                </div>

                <div class = "user_area col-sm-8 col-sm-offset-1">
                    <div class = "row">
                        <div class = "photo col-sm-2">
                            @if(!isset($page))
                              <img border="0" alt="Photo" src="{{Auth::user()->imageurl}}" width="100" height="100">
                            @endif
                            @if(isset($page))
                              <img border="0" alt="Photo" src="{{$user->imageurl}}" width="100" height="100">
                            @endif
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
                                                @if(!isset($page))
                                                  {{ Auth::user()->username }}
                                                @endif
                                                @if(isset($page))
                                                  {{ $user->username }}
                                                @endif
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
                                                @if(!isset($page))
                                                  {{ Auth::user()->firstname ." ". Auth::user()->lastname }}
                                                @endif
                                                @if(isset($page))
                                                  {{ $user->username }}
                                                @endif
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
                                                @if(!isset($page))
                                                  {{ Auth::user()->email }}
                                                @endif
                                                @if(isset($page))
                                                  {{ $user->username }}
                                                @endif
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
