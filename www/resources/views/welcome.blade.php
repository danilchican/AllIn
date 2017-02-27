@extends('layouts.app')

@section('styles')
    <style>
        .welcome-page {
            text-align: center;
        }

        .container-basic {
            padding-top: 25px;
            padding-bottom: 25px;
            background-color: #127cd0;
            color: #fff;
        }

        .container-additional {
            padding-top: 25px;
            padding-bottom: 25px;
            background-color: #fff;
            color: inherit;
        }

        .container-third {
            padding-top: 25px;
            padding-bottom: 150px;
            background-color: inherit;
            color: inherit;
        }

        .container-boarder {
            height: 100px;
            padding-top: 25px;
            padding-bottom: 25px;
            background-color: inherit;
        }

        .start-button, .start-button:hover, .start-button:focus, .start-button:enabled {
            color: black !important;
            background-color: yellow !important;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            height: 50px;
            width: 300px;
            border-radius: 25px;
            box-shadow: 0 0 13px rgba(0,0,0,0.5) !important;
        }

    </style>
@endsection

@section('content')
    <div class="welcome-page">
        <div class="container-basic">
            <h1>Welcome</h1>
            <p class="lead"><br>
                Вам надоело тратить время в социальных сетях на размещение рекламы? <br>
                Или на поддержание своего статуса?<br>
                У вас много аккаунтов в социальных сетях?<br>
                Тогда наш сервис поможет решить все эти вопросы<br>

                <br>
                <img src="/image/bkg.png" alt="hahah" style="height: auto; width: 300px"/>
            </p>

            <a href="/register" class="btn btn-default btn-lg btn-block start-button" role="button">Start now!</a>
        </div>

        <div class="container-boarder">

        </div>

        <div class="container-additional">
            <h1>Additional information here</h1>
            <p class="lead">Text here<br>
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
            </p>
        </div>

        <div class="container-third">
            <h1>Third information here</h1>
            <p class="lead">Text here
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
                <br>Info
            </p>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
@endsection

