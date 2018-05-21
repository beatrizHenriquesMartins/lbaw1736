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

            <li class="breadcrumb-item active" aria-current="page">
                Add Product
            </li>
        </ol>
    </nav>

    <form method="post" action="{{route('addProduct')}}" enctype="multipart/form-data">
        @include('partials.addproductform')
    </form>
@endsection
