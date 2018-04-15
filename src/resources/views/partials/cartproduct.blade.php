<div class="product">
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
        <h4>
            {{$cart->brand->name}}
        </h4>
        <h5>
            {{$cart->category->categoryName}}
        </h5>
        <h5>
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
                <button type="button" class="btn btn-danger pull-right">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
