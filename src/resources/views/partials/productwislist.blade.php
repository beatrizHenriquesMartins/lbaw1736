<div class="product">
    <div class="product-image">
        <img src="{{ $product->imageurl }}" alt="Product Image">
    </div>

    <div class="product-name">
        <h3>
            {{ $product->name }}
        </h3>

        <h5>
            {{ $card->price }}
        </h5>
    </div>

    <div class="product-class">
        <div class="btns">
            <div class="cart-btn">
                <button type="button" class="btn btn-danger pull-right" data-toggle="modal"
                        data-target="#exampleModal">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>
