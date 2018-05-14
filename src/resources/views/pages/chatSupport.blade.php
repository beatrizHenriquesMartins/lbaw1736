@extends('layouts.main', ['type' => $type])

<!-- content of page -->
@section('content')
    <div class="container">
        <div class="card-columns col-sm-12">
            <div id="listOfPeople" class="card-columns col-sm-3">
                <div id="searchChatByPeople" class="card-columns col-sm-3">
                    <input id="searchUserChat" type="text" name="search" placeholder="Search..">
                </div>

                @each('partials.people', $peoples, 'people')

            </div>

            <div class="card-columns col-sm-9">
                <div id="message" class="card-columns col-sm-1">
                    <h5>
                        message
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection