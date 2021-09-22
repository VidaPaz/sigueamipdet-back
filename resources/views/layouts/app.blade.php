<!DOCTYPE html>
<html lang="en" class="color-theme-blue">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="img-src * data:; default-src *; style-src * 'self' 'unsafe-inline'; media-src *; script-src * 'unsafe-inline' 'unsafe-eval'">
    <title>cpt</title>
    <link rel="stylesheet" href="/vendor/materializeicon/material-icons.css">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link href="/vendor/swiper/css/swiper.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">

</head>
<body>
<div class="row no-gutters vh-100 loader-screen">
    <div class="bg-template background-overlay"></div>
    <div class="col align-self-center text-white text-center">
        <img src="/images/cyp.png" alt="logo" width="100px">
        <h1 class="mb-0 mt-3">Confianza</h1>
        <p class="text-mute subtitle"> y Paz</p>
        <div class="loader-ractangls">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
@yield('content')
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

<!-- cookie js -->
<script src="/vendor/cookie/jquery.cookie.js"></script>

<!-- swiper js -->
<script src="/vendor/swiper/js/swiper.min.js"></script>
<script src="/js/jquery.blockUI.js"></script>

<!-- swiper js -->
<script src="/vendor/sparklines/jquery.sparkline.min.js"></script>
<script src="/js/sweetalert29.js"></script>
<!-- template custom js -->
<script src="/js/main.js"></script>
<script src="/js/index.js"></script>
@stack('scripts')

<!-- built files will be auto injected -->
</body>
</html>
