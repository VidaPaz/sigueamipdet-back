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
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="header-area" id="headerArea">
            <div class="container h-100 d-flex align-items-center justify-content-between">
                <!-- Back Button-->
                <div class="back-button">
                </div>
                <!-- Page Title-->
                <div class="page-heading">
                    <h6 class="mb-0">RESTABLECER CONTRASEÑA</h6>
                </div>
                <!-- Search Form-->
                <div class="search-form"><a href="#"><i class="lni lni-user"></i></a></div>
            </div>
        </div>
        <!-- Shape-->
        <div class="login-shape"><img src="/img/core-img/login.png" alt=""></div>
        <div class="login-shape2"><img src="/img/core-img/login2.png" alt=""></div>
        <div class="container">
            <!-- Login Text-->
            <div class="login-text text-center"><img class="login-img" src="/images/logo.png" alt="">
                <h3 class="mb-0">Bienvenido!</h3>
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
            <!-- Register Form-->
            <div class="register-form mt-5 px-3">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group text-left mb-4">
                        <label for="username"><i class="lni lni-envelope"></i></label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" >
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group text-left mb-4">
                        <label for="password"><i class="lni lni-lock"></i></label>
                        <input class="form-control" id="password" type="password" placeholder="Contraseña" name="password" required autocomplete="new-password" >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group text-left mb-4">
                        <label for="new-password"><i class="lni lni-lock"></i></label>
                        <input class="form-control" id="new-password" type="password"  placeholder="Confirmar contraseña" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <button class="btn btn-default btn-lg w-100"  type="submit">Restablecer contraseña</button>
                </form>
            </div>
            <!-- Login Meta-->
            <br>
            <br>
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
