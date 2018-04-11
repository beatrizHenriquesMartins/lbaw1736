@extends('layouts.main')

<!-- lists CSS -->
<link href="css/lists.css" rel="stylesheet">

<!-- Cart Links -->
<link href="css/cart.css" rel="stylesheet">

@section('content')

<!-- breadcrumbs -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/homepage">
                Homepage
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="customer_profile.html">
                Profile
            </a>
        </li>

        <li class="breadcrumb-item" aria-current="page">
            List of Favorites
        </li>
    </ol>
</nav>

<div class="container-fluid main">
    <div class="row-fluid category-section">
        <div class = "sidelinks col-sm-2">
            <div class="list-group">
                <a href="customer_profile.html" class="list-group-item list-group-item-action">
                    Profile
                </a>

                <a href="list_purchases.html" class="list-group-item list-group-item-action">
                    List of Purchases
                </a>

                <a href="list_favourites.html" class="list-group-item list-group-item-action active">
                    List of Favourites
                </a>
            </div>
        </div>
        <div class = "category-products col-sm-8 col-sm-offset-1">
          @each('partials.productwishlist', $products, 'product')

        </div>
    </div>
</div>

@endsection