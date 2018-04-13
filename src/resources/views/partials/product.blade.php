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

            <!--<h4>
                Alma de Luce
            </h4>-->

            <h5>
                {{$product->price}}
            </h5>

            <div class="description">
              {{$product->bigdescription}}
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="product-class">
            <div class="rating">
                <span class="rating-addon align-content-center">
                    <i class="fa fa-star">
                    </i>
                </span>

                <span class="rating-addon align-content-center">
                    <i class="fa fa-star">
                    </i>
                </span>

                <span class="rating-addon align-content-center">
                    <i class="fa fa-star">
                    </i>
                </span>

                <span class="rating-addon align-content-center grey">
                    <i class="fa fa-star">
                    </i>
                </span>

                <span class="rating-addon align-content-center grey">
                    <i class="fa fa-star">
                    </i>
                </span>
            </div>

            <div class="btns">
                <div class="cart-btn">
                    <a class="btn btn-success" role="button">
                        Add Cart
                    </a>
                </div>

                <div class="fav-btn">
                  <a role="button" class="btn btn-info">
                      Add Favourites
                  </a>
                </div>
            </div>
        </div>
    </div>
</div>
