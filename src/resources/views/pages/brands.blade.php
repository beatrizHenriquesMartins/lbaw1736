@extends('layouts.main', ['type' => $type])

@section('title', $title)

@section('content')

     <!-- breadcrumbs -->
        <nav id="breadcrumbs" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('homepage')}}">
                        Homepage
                    </a>
                </li>

                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{route('homepage')}}">
                        Profile
                    </a>
                </li>

                <li class="breadcrumb-item">
                    Brands
                </li>

            </ol>
        </nav>

        <div class="container-fluid main">
          <div class="row-fluid category-section wishlist-section">
                <div class = "sidelinks col-sm-2">
                    <div class="list-group">

                            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                                Profile
                            </a>

                            <a href="{{ route('brands') }}" class="list-group-item list-group-item-action active">
                                Brands
                            </a>
                    </div>
                </div>
                <div class = "category-products wishlist-products col-sm-8 col-sm-offset-1">
                    <?php for($j = 0; $j < count($brands); $j++) {?>
                        <?php if($j==0) {?>
                            <div class="inner-brand-container brand-profile">
                                <div class="card-columns">
                        <?php } ?>
                        <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                            <div class="brand-banner-box stretch">
                                <a href="/brands/{{$brands[$j]->brandname}}">
                                    <img src="{{$brands[$j]->brandimgurl}}" alt="Brand {{$brands[$j]->brandname}}" class="img-responsive img-center">
                                </a>
                            </div>
                        </div>
                        <?php if($j % 3 == 2 && $j != 0 && $j < (count($brands) - 1)) {?>
                              </div>
                          </div>
                          <div class="inner-brand-container">
                              <div class="card-columns">
                        <?php }?>
                        <?php if($j % 3 == 2 && $j != 0 && $j == (count($brands) - 1)) {?>
                              </div>
                          </div>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
@endsection
