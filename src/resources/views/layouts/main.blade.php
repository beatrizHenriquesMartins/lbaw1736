<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Amazonas
        </title>

         <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- CSS -->
        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <!-- Website Font style-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

        <!-- TopBar CSS -->
        <link href="/css/topbar.css" rel="stylesheet">

        <!-- Homepage CSS -->
        <link href="/css/homepage.css" rel="stylesheet" type="text/css" >

        <!-- login style -->
        <link rel="stylesheet" href="/css/login.css" type="text/css">

        <!-- Company Links -->
        <link href="/css/company_links.css" rel="stylesheet">

        <!-- footer style -->
        <link rel="stylesheet" href="/css/footer.css" type="text/css">

        <!-- lists CSS -->
        <link href="/css/lists.css" rel="stylesheet" type="text/css" >

        <!-- Category CSS -->
        <link href="/css/category.css" rel="stylesheet" type="text/css" >

        <!-- Category CSS -->
        <link href="/css/customer_profile.css" rel="stylesheet" type="text/css" >

        <!-- Category CSS -->
        <link href="/css/customer_edit_profile.css" rel="stylesheet" type="text/css" >

        <!-- Cart Links -->
        <link href="/css/cart.css" rel="stylesheet" type="text/css" >
        <link href="/css/cart_order.css" rel="stylesheet" type="text/css" >
        <link href="/css/cart_payment.css" rel="stylesheet" type="text/css" >

        <!-- breadcrumb path css -->
        <link href="/css/breadcrumb_path.css" rel="stylesheet" type="text/css" >

        <!-- product CSS -->
        <link href="/css/product.css" rel="stylesheet" type="text/css" >

        <!-- about us CSS -->
        <link href="/css/aboutus.css" rel="stylesheet" type="text/css" >

        <!-- Admin CSS -->
        <link href="/css/admin.css" rel="stylesheet" type="text/css" >

        <!-- faq CSS -->
        <link href="/css/faq.css" rel="stylesheet" type="text/css" >

        <!-- chatSupport CSS -->
        <link href="/css/chatSupport.css" rel="stylesheet" type="text/css" >


        <link href="/css/chatClient.css" rel="stylesheet" type="text/css" >

        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">

        <!-- icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- icons -->
        <link href="/css/page_404.css" rel="stylesheet">
        <!-- CSS -->

        <link rel="icon" type="image/png"  href="/images/icon.png" />

        <script language="JavaScript" type="text/javascript" src="/js/bootstrap-rating-input.min.js" defer></script>
        <script language="JavaScript" type="text/javascript" src="/js/app.js" defer></script>

        <script language="JavaScript" type="text/javascript" src="/js/jquery.js"></script>
        <script language="JavaScript" type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    </head>

    <body>
    <main>
        <div class="teste">
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
                            <form class="navbar-form navbar-right" id="navBarSearchForm" action="{{route('search')}}"
                                  method="get">

                                <input class="form-control" type="text" placeholder="Search..." name="input">

                                <button type="submit" class="btn btn-dark">
                                    GO!
                                </button>
                            </form>
                        </div>

                        @if (Auth::check())
                            <div class="col-sm-3 flex-item sign">
                                <span class="hi">
                                    Hi,
                                </span>

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle align-text-top" type="button"
                                            id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">

                                        {{ Auth::user()->firstname }}

                                        <i class="fa fa-caret-down">
                                        </i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/profile') }}">
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

                                <div class="user-img">
                                    <a href="{{ url('/profile') }}">
                                        <img class="mb-4"  src="{{Auth::user()->imageurl}}" alt="logo" >
                                    </a>

                                    <!-- </form> -->
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
                            <!-- </div> -->
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
                            @if(Auth::check())
                                <li>
                                    <a href="{{ url('/profile') }}" class="fa fa-user">
                                    </a>
                                </li>

                                @if($type == 1)
                                    <li>
                                        <a href="{{ url('/wishlist') }}" class="fa fa-heart">
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('/cart') }}" class="fa fa-shopping-cart">
                                        </a>
                                    </li>
                                @endif

                                @if($type == 2)
                                    <li>
                                        <a href="{{ url('/newproduct') }}" class="fa fa-plus">
                                        </a>
                                    </li>
                                @endif

                                @if($type == 3)
                                    <li>
                                        <a href="{{ url('/messages/-1') }}" class="fa fa-comment">
                                        </a>
                                    </li>
                                @endif

                                @if($type == 4)
                                    <li>
                                        <a href="{{ url('/newproduct') }}" class="fa fa-plus">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/clients') }}" class="fa fa-users">
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if(!Auth::check())
                                <li>
                                    <a href="{{ url('/login') }}" class="fa fa-sign-in">
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url('/register') }}" class="fa fa-user-plus">
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ url('/homepage') }}" class="fa fa-home">
                                </a>
                            </li>
                        </ul>

                        <!-- the collapsing menu -->
                        <div class="collapse navbar-collapse navbar-left" id="navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                @each('partials.category', $categories, 'category')
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <section id="content">
                @yield('content')
            </section>

            @if($type == 1)
                <div class="container" id="container-chat">
                    <div class="row chat-window col-xs-12 col-md-3" id="chat_window_1" style="margin-left:10px;">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading top-bar">
                                    <div class="col-md-8 col-xs-8">
                                        <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-comment">
                                            </span>

                                            Chat
                                        </h3>
                                    </div>

                                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                                        <a href="#">
                                            <span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim">
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <div class="panel-body msg_container_base">
                                    @each('partials.messages', $messages, 'message')
                                </div>

                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input id="btn-input" type="text" class="form-control input-sm chat_input"
                                               placeholder="Write your message here..." />

                                        <span class="input-group-btn">
                                            <a class="btn btn-primary btn-sm" id="btn-chat">
                                                Send
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!--Company Links-->
        <div>
            <div class ="company_links container-fluid">
                <div class="col-sm-10">
                </div>

                <div class="col-sm-2">
                    <div class="row-fluid">
                        <a href="{{ url('/aboutus') }}">
                            <h4>
                                About Amazonas
                            </h4>
                        </a>
                    </div>

                    <div class="row-fluid">
                        <a href="{{ url('/faq') }}">
                            FAQ
                        </a>
                    </div>

                    <div class="row-fluid">
                        <a href="{{ url('/contactus') }}">
                            Contact us
                        </a>
                    </div>

                    <div class="row-fluid">
                        <a href="{{ url('/terms') }}">
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
