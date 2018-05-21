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

            <li class="breadcrumb-item">
                <a href="{{route('profile')}}">
                    Profile
                </a>
            </li>

            <li class="breadcrumb-item" aria-current="page">
                List of Purchases
            </li>
        </ol>
    </nav>

    <div class="container-fluid main">
        <div class="row-fluid category-section wishlist-section">
            <div class = "sidelinks col-sm-2">
                <div class="list-group">
                    <a href="{{route('profile')}}" class="list-group-item list-group-item-action">
                        Profile
                    </a>

                    <a href="{{route('purchases')}}" class="list-group-item list-group-item-action active">
                        List of Purchases
                    </a>

                    <a href="{{route('wishlist')}}" class="list-group-item list-group-item-action">
                        List of Favourites
                    </a>

                    <a href="{{route('cart')}}" class="list-group-item list-group-item-action">
                        Cart
                    </a>
                </div>
            </div>

            <div class = "category-products col-sm-10 col-sm-offset-1 purchases-products">
                @each('partials.productpurchases', $products, 'product')
            </div>
        </div>
    </div>
@endsection
