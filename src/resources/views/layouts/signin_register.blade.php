<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Amazonas
        </title>

        <!-- CSS -->
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">

        <!-- Website Font style-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

        <!-- footer style -->
        <link rel="stylesheet" href="./css/footer.css" type="text/css">

        <!-- sign in style -->
        <link rel="stylesheet" href="./css/signin.css" type="text/css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">
        <!-- CSS -->

        <!-- icon no separador -->
        <link rel="icon" type="image/png"  href="./images/icon.png" />

        <script type="text/javascript" src="./js/bootstrap.js"></script>
    </head>

    <body>
    <main>
        <section id="content">
            @yield('content')
        </section>

        <footer id="pageFooter">
            <p>Powered by LBAW1736 - MIEIC 2017/2018</p>
        </footer>
    </main>
    </body>
</html>
