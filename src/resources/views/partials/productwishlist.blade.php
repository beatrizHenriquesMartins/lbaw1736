<div class="product" data-id="{{ $product->id }}">
    <div class="product-image">
        <a href="/products/{{ $product->id }}">
          <img src="{{ $product['imageurl'] }}" alt="Product Image">
        </a>
    </div>
    <div class="product-name">
        <h3>
            <a href="/products/{{ $product->id }}">
              {{ $product['name'] }}
            </a>
        </h3>

        <h5>
            {{ $product['price'] }}
        </h5>
    </div>

    <div class="product-class">
        <div class="btns">
            <div class="cart-btn">
              <a href="/wishlist/{{ $product->id}}" class="delete">

                  <button type="button" class="btn btn-danger pull-right">
                      Remove
                  </button>
              </a>
            </div>
        </div>
    </div>
</div>
