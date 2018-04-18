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
                <form class="form-horizontal" method="post" action="{{ route('removeWishlist', ['id' => $product->id]) }}">
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-danger pull-right">
                        Remove
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
