@extends('layouts.main', ['type' => $type])

@section('title', $title)

<!-- content of page -->
@section('content')
    <div class="">
        <div id="chatSheet" class="row">
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

                @each('partials.people', $peoples, 'people')
            </div>

            <div id="message" class="card-columns col-sm-9">
                <div id="exchangeMessages">
                    @each('partials.messages_chat', $messages_chat, 'message')
                </div>

                <div id="writeMessage">
                    <div id="modalDialog_writeMessage" class="modal-dialog" role="document">
                        <div id="modalBody_writeMessage" class="modal-body">
                            <div id="formGroup_writeMessage" data-id="{{$id_client}}">
                                <textarea id="message-text" class="form-control" cols="30" rows="1"></textarea>

                                <a id="buttonSend_writeMessage"  class="btn btn-success">
                                    Send
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
