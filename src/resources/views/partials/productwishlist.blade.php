<div class="product product-wishlist" data-id="{{ $product->id }}">
    <div class="product-image">
        <a href="/products/{{ $product->id }}">
            <img src="{{ $product->imageurl }}" alt="Product Image">
        </a>
    </div>

    <div class="product-name">
        <h3>
            <a href="/products/{{ $product->id }}">
                {{ $product->name }}
            </a>
        </h3>

        <a href="/brands/{{ $product->brand->brandname }}">
            <h4>
                {{$product->brand->brandname}}
            </h4>
        </a>

        <a href="/categories/{{ $product->category->categoryName }}">
          <h5>
              {{$product->category->categoryName}}
          </h5>
        </a>

        <h5>
            {{ $product->price }} €
        </h5>

    </div>

    <div class="product-class">
        <div class="btns">
            <div class="cart-btn">
                <a role="button" class="btn btn-danger pull-right">
                    Remove
                </a>
            </div>
        </div>
    </div>
</div>
