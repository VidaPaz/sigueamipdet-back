@extends('layouts.app')

@section('content')
    <style>
        .siteFooterBar {
            position: fixed;
            z-index: 1000;
            bottom: 0;
            padding-top: 5px;
            width: 100%;
            box-shadow: 0px 0px 25px rgb(207, 207, 207);
            height: 78px;
            color: #9B9B9B;
            background: #F3F3F3;
        }

        .siteFooterBar .content {
            display: block;
            padding: 10px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font: 25px Georgia, "Times New Roman", Times, serif;
            font-size: 14px;
        }
        .siteFooterBar .content .foot { display: inline-block; line-height: 70px; vertical-align: top }

        .siteFooterBar .content .img { display: inline-block;  }
    </style>
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
        <!-- Shape-->
        <div class="login-shape"><img src="img/core-img/login.png" alt=""></div>
        <div class="login-shape2"><img src="img/core-img/login2.png" alt=""></div>
        <div class="container">
            <!-- Login Text-->
            <div class="login-text text-center">
                <!-- Check-->
                <div class="success-check mb-4"><i class="lni lni-checkmark-circle"></i></div>
                <p class="mb-5">Tu contraseña se ha cambiado con éxito, puedes ingresar a nuestra app con tu nueva contraseña!</p>

                <!-- Shapes-->
                <div class="bg-shapes">
                    <div class="shape1"></div>
                    <div class="shape2"></div>
                    <div class="shape3"></div>
                    <div class="shape4"></div>
                    <div class="shape5"></div>
                    <div class="shape6"></div>
                    <div class="shape7"></div>
                    <div class="shape8"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="siteFooterBar">
        <div class="content">
            <img src="/images/logo1.jpeg" width="120px" height="70px" >
            <img src="/images/logo2.jpeg" width="120px" height="70px" >
            <img src="/images/logo3.jpeg" width="80px" height="70px" >
        </div>
    </div>
@endsection
