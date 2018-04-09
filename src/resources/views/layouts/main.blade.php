<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Amazonas
    </title>

    <!-- CSS -->
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Website Font style-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

    <!-- TopBar CSS -->
    <link href="css/topbar.css" rel="stylesheet">

    <!-- Homepage CSS -->
    <link href="css/homepage.css" rel="stylesheet">

    <!-- Company Links -->
    <link href="css/company_links.css" rel="stylesheet">

    <!-- footer style -->
    <link rel="stylesheet" href="./css/footer.css" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">
    <!-- CSS -->

    <link rel="icon" type="image/png"  href="./images/icon.png" />

    <script language="JavaScript" type="text/javascript" src="./js/jquery.js"></script>
    <script language="JavaScript" type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

  </head>
  <body>
    <main>
    <!--  <header>
        <h1><a href="{{ url('/cards') }}">Thingy!</a></h1>
        @if (Auth::check())
        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
        @endif
      </header> -->


      <!-- cabeçalho -->
      <div class="first_class">
          <!-- TOP BAR -->
          <div class="container-fluid topbar">
              <div class="row top">
                  <div class="col-sm-2 flex-item">
                      <a href="{{ url('/homepage') }}">
                          <img class="mb-4"  src="/images/logo_1.png" alt="logo" >
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
                  @if (Auth::check())
                    <div class="col-sm-3 flex-item sign">
                        <span class="hi"> Hi, </span>

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle align-text-top" type="button"
                                    id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->firstname }}

                                <i class="fa fa-caret-down">
                                </i>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item" href="customer_profile.html">
                                        Profile
                                    </a>
                                </li>

                                <div class="dropdown-divider">
                                </div>

                                <li>
                                    <a class="dropdown-item" href="{{ url('/logout') }}">
                                        Sign Out
                                    </a>
                                </li>
                            </div>
                        </div>
                    </div>
                  @endif
                  @if (!Auth::check())
                    <div class="col-sm-3 flex-item sign">
                        <a href="{{ url('/login') }}">
                            Sign in
                        </a>

                        <span>
                            or
                        </span>

                        <a href="{{ url('/register') }}">
                            Sign up
                        </a>
                    </div>
                  @endif
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
                          <a href="{{ url('/listfavourites') }}" class="fa fa-heart">
                          </a>
                      </li>

                      <li>
                          <a href="{{ url('/cart') }}" class="fa fa-shopping-cart">
                          </a>
                      </li>

                      <li>
                          <a href="{{ url('/homepage') }}" class="fa fa-home">
                          </a>
                      </li>
                  </ul>

                  <!-- the collapsing menu -->
                  <div class="collapse navbar-collapse navbar-left" id="navbar-collapse-1">
                      <ul class="nav navbar-nav">
                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Fashion
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Beauty
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Tecnology
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Food
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Culture
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Home
                              </a>
                          </li>

                          <li>
                              <a id="category_font_size" href="{{ url('/category') }}">
                                  Sports
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </nav>
      </div>

      <section id="content">
        @yield('content')
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


    </main>
  </body>
</html>
