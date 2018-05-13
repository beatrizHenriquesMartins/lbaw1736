@extends('layouts.main', ['type' => $type])


@section('content')
 <!-- breadcrumbs -->
 <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="homepage.html">
                        Homepage
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="cart.html">
                        Cart
                    </a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    Cart Order
                </li>
            </ol>
        </nav>

        <div class="order-section">
            <div class="order-topbar row">
                <div class="col-sm-2 payment">
                    <h3>
                        Order
                    </h3>
                </div>

                <div class="col-sm-8">
                </div>
            </div>

            <div class="order-information row">
                <div class="customer-name">
                    <h3>
                        Name
                    </h3>

                    <h5 class="name">
                        Cristiano Ronaldo dos Santos Aveiro
                    </h5>
                </div>

                <div class="customer-email">
                    <h3>
                        Email
                    </h3>

                    <h5 class="email">
                        cr7@gmail.com
                    </h5>
                </div>

                <div class="customer-contact">
                    <h3>
                        NIF
                    </h3>

                    <h5 class="nif">
                        240192549
                    </h5>
                </div>

                <div class = "row addresses">
                    <p>
                        Select one Address:
                    </p>

                    <ul>
                        <li>
                            <div class="col-sm-11">
                                Rua Marco de Canaveses 19 Porto
                            </div>

                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="col-sm-11">
                                Avenida 5 de Outubro 52 Lamego
                            </div>

                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="col-sm-11">
                                Rua de Moçambique 138 Coimbra
                            </div>

                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="btns">
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-danger">
                            Cancel
                        </button>
                    </div>

                    <div class="col-sm-10">
                    </div>

                    <div class="col-sm-1">
                        <a class="btn btn-success pull-right" href="cart_payment.html" role="button">
                            Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>


@endsection