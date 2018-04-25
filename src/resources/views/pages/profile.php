@extends('layouts.main', ['type' => $type])

@section('content')
    @if($type == 2)
    <div class="edit">
        <a href="{{ route('editProfile', ['id' => $user->id]) }}">
            <i class="fa fa-edit">
            </i>
        </a>
    </div>
    @endif

<div class="user-section" data-id="{{$user->id}}">
    <div class="col-sm-4">
        <div class="user-image">
            <img src="{{ asset($user->imageurl) }}" alt="Profile Image">
        </div>
    </div>

    <div class="col-sm-5">
        <div class="user-username">
            <h2>
                {{$user->username}}
            </h2>

             <h5>
                {{$user->email}}
            </h5>

             <!--
            show password as *****?
            -->
            <h5>
               ******
            </h5>

            <h5>
                {{$user->firstname}}
            </h5>

            <h5>
                {{$user->lastname}}
            </h5>

             <h5>
                {{$user->nif}}
            </h5>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="user-class">
            <div class="btns">
                <div class="user-btn">
                    <a class="btn btn-success" role="submit" >
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection