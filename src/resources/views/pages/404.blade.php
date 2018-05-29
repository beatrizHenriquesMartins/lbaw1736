@extends('layouts.main', ['type' => $type])

@section('title', '404')

@section('content')
    <div id="content_page_404" class="container d-sm-flex">
        <div id="div_content_404" class="card-columns col-sm-2">
            <div id="image_404">
                <img id="image_error_404" src="./images/error_404.png" alt="404 Error Image">
            </div>

            <div id="message_404">
                <h3>
                    Sorry but this page don't exist!
                </h3>
            </div>
        </div>
    </div>
@endsection
