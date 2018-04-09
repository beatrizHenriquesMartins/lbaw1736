@extends('layouts.app')

@section('content')
<!-- cabeçalho -->
<div class="first_class">
    <!-- TOP BAR -->
    <div class="container-fluid topbar">
        <div class="row top">
            <div class="col-sm-2 flex-item">
                <a href="homepage.html">
                    <img class="mb-4" src="./images/logo_1.png" alt="logo" width="323.75" height="78">
                </a>
            </div>

            <div class="col-sm-3 flex-item search">
                <form class="navbar-form navbar-right" role="search" id="navBarSearchForm" action="/action_page.php">
                    <input class="form-control" type="text" placeholder="Search..." name="search">

                    <a class="btn btn-dark" href="search_result.html" role="button">
                        GO!
                    </a>
                </form>
            </div>

            <div class="col-sm-3 flex-item sign">
                <a href="signin.html">
                    Sign in
                </a>

                <span>
                    or
                </span>

                <a href="register.html">
                    Sign up
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-static-top custom-navbar" role="navigation">
        <div class="navBar-container">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                <span class="sr-only">
                    Toggle navigation
                </span>

                <span class="icon-bar">
                </span>

                <span class="icon-bar">
                </span>

                <span class="icon-bar">
                </span>
            </button>

            <!-- Non-collapsing right-side icons -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="list_favourites.html" class="fa fa-heart">
                    </a>
                </li>

                <li>
                    <a href="cart.html" class="fa fa-shopping-cart">
                    </a>
                </li>

                <li>
                    <a href="homepage.html" class="fa fa-home">
                    </a>
                </li>
            </ul>

            <!-- the collapsing menu -->
            <div class="collapse navbar-collapse navbar-left" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a id="category_font_size" href="category.html">
                            Fashion
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Beauty
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Tecnology
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Food
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Culture
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Home
                        </a>
                    </li>

                    <li>
                        <a id="category_font_size" href="category.html">
                            Sports
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<section id="info">
  @include(pages.$info)
</section>

<!--Company Links-->
<div>
    <div class ="company_links container-fluid">
        <div class="col-sm-10">
        </div>

        <div class="col-sm-2">
            <div class="row-fluid">
                <a href="#">
                    <h4>
                        About Amazonas
                    </h4>
                </a>
            </div>

            <div class="row-fluid">
                <a href="#">
                    Contact us
                </a>
            </div>

            <div class="row-fluid">
                <a href="#">
                    Terms & Conditions
                </a>
            </div>
        </div>
    </div>

    <div>
        <footer id="pageFooter">
            <p>
                Powered by LBAW1736 - MIEIC 2017/2018
            </p>
        </footer>
    </div>
</div>
