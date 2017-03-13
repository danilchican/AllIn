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
            font-style: inherit;
            font-size: 20px;
        }

        .container-third {
            padding-top: 25px;
            padding-bottom: 150px;
            background-color: inherit;
            color: inherit;
            font-style: inherit;
            font-size: 20px;
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
            <h1>Маркетинг и продвижение в социальных сетях
                <br>с надежным сервисом для SMM</h1>
            <br>Создавайте отложенные посты и публикуйте их сразу
            <br>во всех выбранных аккаунтах в несколько кликов с помощью одного сервиса.
            <br>Вовлекайте аудиторию. Превращайте ваши страницы
            <br>в инструмент маркетинга в социальных сетях.

            <h1>Визуальный контент</h1>
            <br>Добавляйте несколько изображений к одной публикации.
            <br>Создавайте кликабельные интерактивные посты!

        </div>

        <div class="container-third">
            <h1>Анализ социальных сетей</h1>
            <br>Запустив анализ социальных сетей, вы можете проводить контент-анализ
            <br>и отслеживать, как контент, который вы публикуете в разные соцсети,
            <br>влияет на рост подписчиков и вовлеченность аудитории.

            <h1>Календарь и история публикаций</h1>
            <br>Всегда будьте в курсе статуса ваших публикаций.

        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
@endsection

