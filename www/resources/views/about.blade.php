@extends('layouts.app')

@section('styles')
    <style>
        .about-info {
            padding-top: 25px;
            padding-bottom: 25px;
            text-align: center;
            color: #fff;
            background-color: #127cd0;
        }

        .team-info {
            padding-top: 10px;
            padding-bottom: 25px;
            text-align: center;
            color: inherit;
            background-color: inherit;
        }

        .mate1 {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

            background: url("https://pp.vk.me/c837435/v837435121/1ca4e/0dWQ0qWiIcQ.jpg") no-repeat;
            background-size: 200px 300px;
            background-position-y: -35px;
            background-position-x: center;

            alignment: center;

            margin: 0 auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .mate2 {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

            background: url("https://pp.vk.me/c604728/v604728244/46d3/RkLp3BGd3PE.jpg") no-repeat;
            background-size: 540px 400px;
            background-position-y: -85px;
            background-position-x: -135px;

            alignment: center;

            margin: 0 auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .mate3 {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

            background: url("https://pp.vk.me/c631821/v631821739/38afb/bLQxANJLoEo.jpg") no-repeat;
            background-size: 380px 250px;
            background-position-y: -10px;
            background-position-x: -135px;

            alignment: center;

            margin: 0 auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .mate4 {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

            background: url("https://pp.vk.me/c624526/v624526468/12339/23qzWM4OoAc.jpg") no-repeat;
            background-size: 680px 880px;
            background-position-y: -115px;
            background-position-x: center;

            alignment: center;

            margin: 0 auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .mate5 {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

            background: url("https://vk.com/images/camera_200.png") no-repeat;
            background-size: 200px 200px;
            background-position-y: center;
            background-position-x: center;

            alignment: center;

            margin: 0 auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="about-info">
        <h1>About us</h1>
        <p class="lead">Make your dreams come true with Allin<br> </p>
    </div>
    <div class="team-info">
        <h1>Our team</h1>

        <div class="style-first" style="padding-top: 10px; padding-bottom: 10px">
            <div class="img-div mate1"></div>
            <h2>Alexandr Konikov</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Scrum Master</p>
        </div>

        <div class="style-second" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate2"></div>
            <h2>Ulyana Kiklevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Muse, Android Developer, QA</p>
        </div>

        <div class="style-third" style="padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate3"></div>
            <h2>Vladislav Danilchick</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Back-end Developer, QA</p>
        </div>

        <div class="style-fourth" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate4"></div>
            <h2>Artyom Vasilevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Front-end Developer, QA</p>
        </div>

        <div class="style-fifth" style="padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate5"></div>
            <h2>Andrey Gromyko</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Design, QA</p>
        </div>
    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
@endsection
