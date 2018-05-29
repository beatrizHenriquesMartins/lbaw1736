<!-- breadcrumbs -->
<nav id="breadcrumbs" aria-label="breadcrumb">
    <div class="row">
      <div class="col-sm-11">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/homepage">
                    Homepage
                </a>
            </li>
            <?php $brandname = str_replace(' ', '_', $product->brand->brandname);?>
            <li class="breadcrumb-item">
                <a href="{{route('brand', ['brandname' => $brandname])}}">
                    {{$product->brand->brandname}}
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('category', ['categoryname' => $product->category->categoryname])}}">
                    {{$product->category->categoryname}}
                </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                {{$product->name}}
            </li>
        </ol>
      </div>
      <div class="col-sm-1 help">
          <div class="cart-btn">
              <i class="fa fa-question-circle" data-toggle="modal"
                      data-target="#exampleModal">
              </i>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                   aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="container help">
                              <p>This page contains the information of an product:</p>
                              <a class="btn btn-success" role="button" >
                                  Add Cart
                              </a>
                              <p>Here you can add the product to your cart but you need to be logged in to perform this action</p>
                              <a role="button" class="btn btn-info" >
                                  Add Favourites
                              </a>
                              <p>Here you can add the product to your wishlist but you need to be logged in to perform this action</p>
                              <div class="reviews-section">
                                  <h3>
                                      Be The First One to Comment!!!
                                  </h3>
                              </div>
                              <p>Below the product you'll find the product reviews as shown in the exemple above</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</nav>

@if($usertype == 2 || $usertype == 4)
    <div class="edit">
        <a href="{{ route('editProduct', ['id' => $product->id]) }}">
            <i class="fa fa-edit">
            </i>
        </a>

        <a href="{{ route('removeProduct', ['id' => $product->id]) }}">
            <i class="fa fa-trash">
            </i>
        </a>
    </div>
@endif

<div class="product-section" data-id="{{$product->id}}">
    <div class="col-sm-4">
        <div class="product-image">
            <img src="{{ asset($product->imageurl) }}" alt="{{$product->name}}">
        </div>
    </div>

    <div class="col-sm-5">
        <div class="product-name">
            <h2>
                {{$product->name}}
            </h2>
            <?php $brandname = str_replace(' ', '_', $product->brand->brandname);?>
            <a href="/brands/{{ $brandname }}">
                <h4 class="product-name">
                    {{$product->brand->brandname}}
                </h4>
            </a>

            <h5>{{$product->category->categoryName}}</h5>

            <h5>{{$product->price}} €</h5>

            <div class="description">
                {{$product->bigdescription}}
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="product-class">
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
                    <a class="btn btn-success" role="button" >
                        Add Cart
                    </a>
                </div>

                <div class="fav-btn">
                    <a role="button" class="btn btn-info" >
                        Add Favourites
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
