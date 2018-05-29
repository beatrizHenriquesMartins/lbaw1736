@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')
     <!-- breadcrumbs -->
     <nav id="breadcrumbs" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/homepage">
                    Homepage
                </a>
            </li>

        

            <li class="breadcrumb-item" aria-current="page">
                Confirmation Payment    
            </li>
        </ol>
    </nav>
    @if($names && count($names) != 0)
        @foreach($names as $id => $username)
            <div class="user-payment row-fluid" id_purchase = {{ $id }} >
                <div class = "col-sm-5">
                    {{$username}}
                </div>
                <div class = "col-sm-3">
                    {{$costs[$id]}}
                </div>
                <div class = "col-sm-2">
                <button id = "button-confirmpayment" type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-ok"></span> Ok 
        </button>
                </div>                
            </div>
        @endforeach
    @endif

@endsection