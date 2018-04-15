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
        <h4>
            {{$product->brand->name}}
        </h4>
        <h5>
            {{$product->category->categoryName}}
        </h5>
        <h5>
            {{ $product['price'] }} €
        </h5>
    </div>

    <div class="product-class">
        <div class="btns">
            <div class="cart-btn">
                <button type="button" class="btn btn-danger pull-right">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>
