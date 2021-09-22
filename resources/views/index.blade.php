@extends('layouts.app')

@section('content')
    <div class="wrapper bg-template">
        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                </div>
                <div class="col text-center"></div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <!-- header ends -->

        <div class="swiper-container introduction vh-100">
            <div class="swiper-wrapper">
                <div class="swiper-slide overflow-hidden bg-gradient-cyan text-white">
                    <div class="row no-gutters h-100">
                        <div class="col align-self-center text-center">
                            <img src="/images/logo.png" alt="" class="mw-100 mx-auto mb-4">
                            <br><br>
                            <h2 class="text-uppercase font-weight-light">SIGUE A MI PDET</h2>
                            <p class="text-mute" style="color: #ffffff">Programa de Construcción de Confianza y Paz Territorial en Clave PDET.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination bullets-white text-left"></div>
        </div>
        <a href="login.html" class="btn btn-light btn-lg button-fab right-bottom text-uppercase" style="display: none">Login <i class="material-icons vm">arrow_forward</i></a>
    </div>
@endsection
@push('scripts')
    <script>
    $(window).on('load', function() {
        var swiper = new Swiper('.introduction', {
            pagination: {
                el: '.swiper-pagination',
            },
        });
    })

</script>
@endpush