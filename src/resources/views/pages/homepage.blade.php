@extends('layouts.main', ['type' => $type])


@section('content')
    <!-- Carousel -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active">
            </li>

            <li data-target="#myCarousel" data-slide-to="1">
            </li>

            <li data-target="#myCarousel" data-slide-to="2">
            </li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active">
                <img src="{{$products[0]->imageurl}}" alt="Logo">
            </div>

            <div class="item">
                <img src="{{$products[1]->imageurl}}" alt="Logo">
            </div>

            <div class="item">
                <img src="{{$products[2]->imageurl}}" alt="Logo">
            </div>
        </div>

        <!-- Left controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left">
            </span>

            <span class="sr-only">
                Previous
            </span>
        </a>

        <!-- right controls -->
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right">
            </span>

            <span class="sr-only">
                Next
            </span>
        </a>
    </div>

    <div id="brand-container" class="container">
        <div id="inner-brand-container" class="container">
          <div class="card-columns">
              <?php for($j = 0; $j < 4; $j++) {
                if($j == 0 || $j == 3) {?>
                  <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                    @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                  </div>
                <?php } if($j == 1) {?>
                    <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                      @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                <?php } if($j == 2) {?>
                      @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                    </div>
                <?php }
              } ?>
          </div>
        </div>
        <div id="inner-brand-container" class="container">
          <div class="card-columns">
              <?php for($j = 4; $j < 9; $j++) {
                if($j == 6) {?>
                  <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                    @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                  </div>
                <?php } if($j == 4 || $j == 7) {?>
                    <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                      @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                <?php } if($j == 5 || $j == 8) {?>
                      @include('partials.brandhomepage', ['elem' => $j, 'brand' => $brands[$j]])
                    </div>
                <?php }
              } ?>
          </div>
        </div>

    </div>

@endsection
