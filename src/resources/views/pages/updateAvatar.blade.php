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
            </div>

            <div class = "user_area col-sm-8 col-sm-offset-1">
                <div class = "row">
                    <div class = "photo col-sm-2">
                        <img class="rounded-circle" src="/storage/avatars/{{ Auth::user()->imageurl }}" />
                        <!-- badge -->
                        <div class="rank-label-container">
                            <span class="label label-default rank-label">{{Auth::user()->username}}</span>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <form role="form" action="{{ route('updateAvatar') }}"" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="imageurl" id="avatarFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection