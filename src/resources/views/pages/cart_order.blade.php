@extends('layouts.main', ['type' => $type])

@section('title', $title)

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
                <a href="/cart">
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
                    {{ Auth::user()->firstname ." ". Auth::user()->lastname }}
                </h5>
            </div>

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
                    <input type = "text" name = "nif">
                </h5>
            </div>

            <div class = "row addresses">
                <p>
                    Select one Address:
                </p>

                <ul>
                    @foreach ($addresses as $entry)
                        <li>
                            <div class="col-sm-11">
                                {{ $entry->address . " " . $entry->city . " " . $entry->country}}
                            </div>

                            <div class="col-sm-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="btns">
                <div class="btns">
                    <div class="col-sm-1">
                        <button  class="btn btn-danger">
                            Cancel
                        </button>
                    </div>

                    <div class="col-sm-10">
                    </div>

                    <div class="col-sm-1">
                        <a class="btn btn-success pull-right" href="#" role="button">
                            Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form style = "display: hidden" action ="{{route('cart_payment')}}" method = "post" id="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">       
        <input type = "hidden" id="selectedAddr" name = "selectedAddr" value=""/>
        <input type = "hidden" id="nifForm" name = "nif" value=""/>
    </form>
@endsection
