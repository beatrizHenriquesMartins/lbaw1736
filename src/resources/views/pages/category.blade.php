@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')
    <nav id="breadcrumbs" aria-label="breadcrumb">
        <div class="col-sm-11">

          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <a href="{{route('homepage')}}">
                      Homepage
                  </a>
              </li>

              <li class="breadcrumb-item" aria-current="page">
                  {{$categoryname}}
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
                                <p>This page contains the products of an category:</p>
                                <a class="btn btn-success" role="button" >
                                    Add Cart
                                </a>
                                <p>Here you can add the product to your cart but you need to be logged in to perform this action</p>
                                <a role="button" class="btn btn-info" >
                                    Add Favourites
                                </a>
                                <p>Here you can add the product to your wishlist but you need to be logged in to perform this action</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container category-section">
        <div class="category-topbar row">
            <div class="col-sm-10 category">
                <h3>
                    {{$categoryname}}
                </h3>
            </div>

            <div class="col-sm-2 dropdown">
                <button class="btn btn-secondary dropdown-toggle pull-right"  data-toggle="dropdown">
                    Order by

                    <span class="caret">
                    </span>
                </button>

                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="#">
                            Preço Ascendente
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            Preço Descendente
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            Rating Ascendente
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            Rating Descendente
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <?php
            $num_elems = count($products);

            $elems_per_row = 4;
            $rest = $elems_per_row - ($num_elems%$elems_per_row);
            if($num_elems%$elems_per_row == 0)
                $rest = 0;

            $num_rows = ceil($num_elems / $elems_per_row);
            $col_division = 12 / $elems_per_row; //DONT CHANGE. Used for grid position purposes

            for($i = 0; $i < $num_rows; $i++) {?>
                <div class="category-products">
                    <div class="product-row">
                        <?php for($j = 0; $j < $elems_per_row && $num_elems > 0; $j++, $num_elems--) {
                            $actual_elem = $i*$elems_per_row + $j;?>
                  @include('partials.categoryproduct', ['product' => $products[$actual_elem], 'reviewmed' => $reviewsmed[$actual_elem]])
            <?php } ?>
            <?php if($num_rows == ceil($actual_elem/4)) {?>
                  <?php for($k = 0; $k < $rest; $k++) {?>
                      <div class="product-section empty">
                      </div>
                  <?php } ?>
            <?php } ?>
          </div>
      </div>
    <?php } ?>
</div>
<div class="category-links">
  {{ $products->links() }}
</div>
@endsection
