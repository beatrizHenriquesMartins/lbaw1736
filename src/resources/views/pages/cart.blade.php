@extends('layouts.main')


@section('content')



<!-- breadcrumbs -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/homepage">
                Homepage
            </a>
        </li>

        <li class="breadcrumb-item" aria-current="page">
            Cart
        </li>
    </ol>
</nav>


<div class="container category-section">
    <div class="category-topbar row">
        <div class="col-sm-2 category">
            <h2>
                Cart
            </h2>
        </div>

        <div class="col-sm-8">
        </div>
    </div>

    <div class="category-products row">
      @each('partials.cartproduct', $carts, 'cart')

    </div>
    @if(count($carts)!=0)
      <div class="final">
          <div class="delete-cart">
              <div class="blankspace">
              </div>

              <div class="delete-cart-btn">
                  <button type="button" class="btn btn-danger">
                      Delete Cart
                  </button>
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

                      <h3>
                          {{$cost}} €
                      </h3>
                  </div>

                  <div class="order">
                      <div class="order-btn">
                          <a class="btn btn-success pull-right" href="cart_order.html" role="button">
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
