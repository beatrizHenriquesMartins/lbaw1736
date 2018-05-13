@extends('layouts.main', ['type' => $type])


@section('content')
    <div id="content_page_404" class="container d-sm-flex">
        <div id="div_content_404" class="card-columns col-sm-2">
            <div id="image_404">
                <img id="image_error_404" src="./images/error_404.png">
            </div>

            <div id="message_404">
                <h3>
                    Sorry but this page don't exist!
                </h3>
            </div>
        </div>
    </div>
@endsection
