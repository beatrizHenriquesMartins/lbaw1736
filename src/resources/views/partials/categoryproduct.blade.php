<div class="product">
    <a href="/products/{{ $product->id }}">
        <img class="product-img" src="{{ asset($product->imageurl) }}" alt="Card image cap">
    </a>

    <div class="product-body">
        <a href="/products/{{ $product->id }}">
            <h3 class="product-name">
                {{$product->name}}
            </h3>
        </a>

        <h5 class="product-price">
            {{$product->price}} €
        </h5>

        <div class="rating">
          @for($i=0; $i < $reviewmed; $i++)
            <span class="rating-addon align-content-center">
                <i class="fa fa-star">
                </i>
            </span>
          @endfor
          @for($i=$reviewmed; $i < 5; $i++)
            <span class="rating-addon align-content-center grey">
                <i class="fa fa-star">
                </i>
            </span>
          @endfor
        </div>

        <p class="product-description">
            {{$product->shortdescription}}
        </p>

        <div class="btns">
            <div class="cart-btn">
              <form class="form-horizontal" method="post" action="{{ route('addCart', ['id' => $product->id]) }}">
                  {{ csrf_field() }}
                  <button class="btn btn-success" role="submit" >
                    Add Cart
                  </button>
              </form>
            </div>

            <div class="fav-btn">
              <form class="form-horizontal" method="post" action="{{ route('addwishlist', ['id' => $product->id]) }}">
                  {{ csrf_field() }}
                  <button role="submit" class="btn btn-info" >
                      Add Favourites
                  </button>
              </form>
            </div>
        </div>
    </div>
</div>
