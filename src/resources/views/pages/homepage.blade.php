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
                <img src="./images/brands/alma_de_luce/1.jpg" alt="Logo">
            </div>

            <div class="item">
                <img src="./images/brands/alma_de_luce/2.jpg" alt="Logo">
            </div>

            <div class="item">
                <img src="./images/brands/anita_picnic/slideshow_9.jpg" alt="Logo">
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

    <!-- several imgs -->
    <div id="brand-container" class="container">
        <div id="inner-brand-container" class="container">
            <div class="card-columns">
                <div class="col-sm-4 col-xs-12 brand-box flex-item ">
                    <div class="brand-banner-box stretch">
                        <img src="./images/brands/aldeia_da_roupa_branca/aldeia_da_roupa_branca.png"
                             alt="Banner 1" class="img-responsive img-center">
                    </div>
                </div>

                <div class="col-sm-4 col-xs-12 brand-box flex-item">
                    <div class="brand-banner-box">
                        <img src="./images/brands/briel/briel.png" alt="Banner 2" class="img-responsive img-center">
                    </div>

                    <div class="brand-banner-box">
                        <img src="./images/brands/castelbel/castelbel.png" alt="Banner 2" class="img-responsive img-center">
                    </div>
                </div>

                <div class="col-sm-4 col-xs-12 brand-box flex-item">
                    <div class="brand-banner-box stretch">
                        <img src="./images/brands/bateye/bateye.png" alt="Banner 3" class="img-responsive img-center">
                    </div>
                </div>
            </div>
        </div>

        <div id="inner-brand-container" class="container">
            <div class="card-columns">
                <div class="col-sm-4 col-xs-12 brand-box flex-item">
                    <div class="brand-banner-box">
                        <img src="./images/brands/anita_picnic/anita_picnic.png" alt="Banner 2" class="img-responsive img-center">
                    </div>

                    <div class="brand-banner-box">
                        <img src="./images/brands/coloradd/coloradd.png" alt="Banner 2" class="img-responsive img-center">
                    </div>
                </div>

                <div class="col-sm-4 col-xs-12 brand-box flex-item">
                    <div class="brand-banner-box stretch">
                        <img src="./images/brands/boca_do_lobo/boca_do_lobo.png" alt="Banner 3" class="img-responsive img-center">
                    </div>
                </div>

                <div class="col-sm-4 col-xs-12 brand-box flex-item">
                    <div class="brand-banner-box">
                        <img src="./images/brands/bluf/bluf.png" alt="Banner 2" class="img-responsive img-center">
                    </div>

                    <div class="brand-banner-box">
                        <img src="./images/brands/ana_leite/ana_leite.png" alt="Banner 2" class="img-responsive img-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
