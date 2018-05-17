@extends('layouts.main', ['type' => $type])

<!-- content of page -->
@section('content')
    <div class="container">
        <div class="card-columns col-sm-12">
            <div id="listOfPeople" class="card-columns col-sm-3">
                <div id="optionsChat" class="card-columns col-sm-3">
                    <div id="definition" class="card-columns col-sm-1">
                        <a id="definitionIcon" href="" class="fa fa-cog">
                        </a>
                    </div>

                    <div id="sptTitle" class="card-columns col-sm-1">
                        <h5 id="chatTitle">
                            Chat Support
                        </h5>
                    </div>

                    <div id="newMessage" class="card-columns col-sm-1">
                        <a id="newMessageIcon" href="" class="fa fa-edit">
                        </a>
                    </div>
                </div>

                <div id="searchChatByPeople" class="card-columns col-sm-3">
                    <input id="searchUserChat" type="text" name="search" placeholder="Search..">
                </div>

                @each('partials.people', $peoples, 'people')

            </div>

            <div id="message" class="card-columns col-sm-9">
                <h5>
                    message
                </h5>
            </div>
        </div>
    </div>
@endsection