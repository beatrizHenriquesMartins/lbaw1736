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
    @if($payments && count($payments) != 0)
        @foreach($payments as $username => $cost)
        @endforeach
    @endif

@endsection