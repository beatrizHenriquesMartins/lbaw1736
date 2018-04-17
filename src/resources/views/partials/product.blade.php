<!-- breadcrumbs -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/homepage">
                Homepage
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="/search_result/{{$product->categoryname}}">
                {{$product->category->categoryname}}
            </a>
        </li>

        <li class="breadcrumb-item active" aria-current="page">
            {{$product->name}}
        </li>
    </ol>
</nav>
@if($usertype == 2)
  <div class="edit">
    <a href="{{ route('editProduct', ['id' => $product->id]) }}">
      <i class="fa fa-edit"></i>
    </a>
    <a href="{{ route('removeProduct', ['id' => $product->id]) }}">
      <i class="fa fa-trash"></i>
    </a>
  </div>
@endif
<div class="product-section">
    <div class="col-sm-4">
        <div class="product-image">
            <img src="{{ asset($product->imageurl) }}" alt="Product Image">
        </div>
    </div>

    <div class="col-sm-5">
        <div class="product-name">
            <h2>
                {{$product->name}}
            </h2>

            <h4>
                {{$product->brand->name}}
            </h4>
            <h5>
                {{$product->category->categoryName}}
            </h5>
            <h5>
                {{$product->price}} €
            </h5>

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
</div>
