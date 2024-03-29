@extends('layouts.main_cart_payment', ['type' => $type])

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
                <a href="/cart">
                    Cart
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="/cart_order">
                    Cart Order
                </a>
            </li>

            <li class="breadcrumb-item" aria-current="page">
                Cart Payment
            </li>
        </ol>
    </nav>

    <!-- corpo -->
    <div class="order-section">
        <div class="order-topbar row">
            <div class="col-sm-2 payment">
                <h3>
                    Payment
                </h3>
            </div>

            <div class="col-sm-8">
            </div>
        </div>

        <div class="order-information row">
            <div class="information">
                <div class="order">
                    <h3>
                        Order By
                    </h3>
                </div>

                <div class="customer-information-1">
                    <div clas="customer-name">
                        <h3>
                            Name
                        </h3>

                        <h5 class="name">
                            {{ Auth::user()->firstname ." ". Auth::user()->lastname }}
                        </h5>
                    </div>

                    <div class="customer-address">
                        <h3>
                            Address
                        </h3>

                        <h5 class="address-cartpayment" id_address= {{ $address->id_address }}>
                            {{ $address->address . " " . $address->city . " " . $address->country}}
                        </h5>
                    </div>
                </div>

                <div class="customer-information-2">
                    <div class="customer-email">
                        <h3>
                            Email
                        </h3>

                        <h5 class="email">
                            {{ Auth::user()->email }}
                        </h5>
                    </div>

                    <div class="customer-contact">
                        <h3>
                            NIF
                        </h3>

                        <h5 class="nif">
                            {{$nif}}
                        </h5>
                    </div>

                    <div class="customer-blank">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container category-section">
        <div class="category-topbar row">
            <div class="col-sm-2 category">
                <h3>
                    Cart
                </h3>
            </div>

            <div class="col-sm-8">
            </div>
        </div>

        <div class="category-products row flex">
            <div class="section">
                @foreach($carts as $cart)
                    <div class="product">
                        <div class="product-image">
                            <img src="{{ $cart->imageurl }}"  alt="Product Image">
                        </div>

                        <div class="product-name">
                            <h3>
                                {{$cart->brand->brandname}}
                            </h3>

                            <h4>
                                {{$cart->name}}
                            </h4>

                            <h5>
                                {{$cart->price}} €
                            </h5>
                        </div>

                        <div class="product-class">
                            <div class="quantity">
                                <div class="input-group spinner">
                                    <h3>
                                        Quant.:
                                    </h3>

                                    <h3 class="quantity">
                                        {{$cart->pivot->quantity}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="final final-payment">
                    <div class="delete-cart">
                    </div>

                    <div class="blankspace">
                    </div>

                    <div class="total-order">
                        <div class="pull-right">
                            <div class="row-fluid total">
                                <div class = "col-sm-6">
                                <h3>
                                    Total
                                </h3>
                                </div>
                                <div class = "col-sm-6">
                                <h3>
                                &nbsp;{{$cost}} €
                                </h3>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment">
                <div class="MasterCart-btn">
                    <button  class="btn btn-success">
                        Pay MasterCart
                    </button>
                </div>

                <div class="PayPal-btn">
                    <button  class="btn btn-success">
                        PayPal
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
