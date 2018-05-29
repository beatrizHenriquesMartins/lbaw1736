<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="google-signin-client_id" content="876344229012-l89i8ark42rpp6m4rkcd4kr7em43pvhm.apps.googleusercontent.com">
        <title>
            Amazonas
        </title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- CSS -->
        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">

        <!-- Website Font style-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" type="text/css">

        <!-- footer style -->
        <link rel="stylesheet" href="/css/footer.css" type="text/css">

        <!-- sign in style -->
        <link rel="stylesheet" href="/css/signin.css" type="text/css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet">
        <!-- CSS -->

        <!-- icon no separador -->
        <link rel="icon" type="image/png"  href="/images/icon.png" />

    </head>

    <body>
    <main>
        <section id="content">
            @yield('content')
        </section>

    </main>
    </body>
</html>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
