<div class="product-section" data-id="{{$product->id}}">
    <a href="/products/{{ $product->id }}">
        <img class="product-img" src="{{ asset($product->imageurl) }}" alt="Product Image">
    </a>

    <div class="product-body">
        <a href="/products/{{ $product->id }}">
            <h3 class="product-name">
                {{$product->name}}
            </h3>
        </a>
        <?php $brandname = str_replace(' ', '_', $product->brand->brandname); ?>
        <a href="/brands/{{ $brandname }}">
            <h4 class="product-name">
                {{$product->brand->brandname}}
            </h4>
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
        
        @if(Auth::check())
          <div class="btns">
              <div class="stock" style="text-align:center;">
                  @if($product->quantityinstock > 5)
                    <h5 style="color:green; font-size:16px;">In Stock</h5>
                  @endif
                  @if($product->quantityinstock == 0)
                    <h5 style="color:red; font-size:16px;">Not Available</h5>
                  @endif
                  @if($product->quantityinstock > 0 && $product->quantityinstock <= 5)
                    <h5 style="color:red; font-size:16px;">Low Availability</h5>
                  @endif
              </div>
          </div>
        @endif

        <div class="btns">
            <div class="cart-btn">
                <a class="btn btn-success" type="button" >
                  Add Cart
                </a>
            </div>

            <div class="fav-btn">
                <a type="button" class="btn btn-info" >
                    Add Favourites
                </a>
            </div>
        </div>
    </div>
</div>
