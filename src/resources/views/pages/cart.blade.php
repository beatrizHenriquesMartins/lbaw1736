@extends('layouts.main', ['type' => $type])


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
                <a href="/profile">
                    Profile
                </a>
            </li>

            <li class="breadcrumb-item" aria-current="page">
                Cart
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

                    <a href="{{route('purchases')}}" class="list-group-item list-group-item-action">
                        List of Purchases
                    </a>

                    <a href="{{route('wishlist')}}" class="list-group-item list-group-item-action">
                        List of Favourites
                    </a>

                    <a href="{{route('cart')}}" class="list-group-item list-group-item-action active">
                        Cart
                    </a>
                </div>
            </div>

            <div class="category-products wishlist-products col-sm-8 col-sm-offset-1">
                @each('partials.cartproduct', $carts, 'cart')
            </div>
        </div>

        @if(count($carts)!=0)
            <div class="final">
                <div class="delete-cart">
                    <div class="blankspace">
                    </div>

                    <div class="delete-cart-btn">
                        <a role="button" class="btn btn-danger">
                                Empty Cart
                        </a>
                    </div>
                </div>

                <div class="blankspace">
                </div>

                <div class="total-order">
                    <div class="pull-right">
                        <div class="total">
                            <h3>
                                Total
                            </h3>

                            <h3 class="value">
                                {{$cost}} €
                            </h3>
                        </div>

                        <div class="order">
                            <div class="order-btn">
                                <a class="btn btn-success pull-right" href="{{route('cart_order')}}" role="button">
                                    Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
