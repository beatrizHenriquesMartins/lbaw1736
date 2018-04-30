@if($message->sender == "Client")
<div class="row msg_container base_receive">
    <div class="col-md-2 col-xs-2 avatar">
        <img src="{{$message->chatsupport->imageurl}}" class=" img-responsive ">
    </div>
    <div class="col-xs-10 col-md-10">
        <div class="messages msg_receive">
            <p>{{$message->message}}</p>
            <time datetime="2009-11-13">{{$message->chatsupport->username}} • {{date('Y-m-d', strtotime($message->datesent))}}</time>
        </div>
    </div>
</div>
@endif
@if($message->sender == "ChatSupport")
<div class="row msg_container base_sent">
    <div class="col-xs-10 col-md-10">
        <div class="messages msg_sent">
            <p>{{$message->message}}</p>
            <time datetime="2009-11-13">{{$message->client->username}} • {{date('Y-m-d', strtotime($message->datesent))}}</time>
        </div>
    </div>
    <div class="col-md-2 col-xs-2 avatar">
        <img src="{{$message->client->imageurl}}" class=" img-responsive ">
    </div>
</div>
@endif
