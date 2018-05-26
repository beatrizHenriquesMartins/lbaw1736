<div class="product product-cart" data-id="{{ $cart->id }}">
    <div class="product-image">
        <a href="/products/{{ $cart->id }}">
            <img src="{{ $cart->imageurl }}" alt="Product Image">
        </a>
    </div>

    <div class="product-name">
        <a href="/products/{{ $cart->id }}">
            <h3>
                {{$cart->name}}
            </h3>
        </a>
        <?php $brandname = str_replace(' ', '_', $cart->brand->brandname); ?>
        <a href="/brands/{{ $brandname }}">
            <h4>
                {{$cart->brand->brandname}}
            </h4>
        </a>

        <h5>
            {{$cart->category->categoryName}}
        </h5>

        <h5 class="price">
            {{$cart->price}} €
        </h5>
    </div>

    <div class="product-class">
        <div class="quantity">
            <div class="input-group spinner">
                <input type="text" class="form-control" value="{{$cart->pivot->quantity}}">

                <div class="input-group-btn-vertical">
                    <button class="btn btn-default plus" type="button">
                        <span class="number">
                            0
                        </span>

                        <i class="fa fa-caret-up">
                        </i>
                    </button>

                    <button class="btn btn-default minus" type="button">
                        <span class="number">
                            0
                        </span>

                        <i class="fa fa-caret-down">
                        </i>
                    </button>
                </div>
            </div>
        </div>

        <div class="btns">
            <div class="cart-btn">
                <a role="button" class="btn btn-danger pull-right">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>
