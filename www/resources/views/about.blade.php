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
            height: auto;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

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
            height: auto;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;

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
            <img src="/image/team/alexandr.jpg" class="img-div mate1"/>
            <h2>Alexandr Konikov</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Scrum Master</p>
        </div>

        <div class="style-second" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <img src="/image/team/ulyana.jpg" class="img-div mate2"/>
            <h2>Ulyana Kiklevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Muse, Android Developer, QA</p>
        </div>

        <div class="style-third" style="padding-top: 50px; padding-bottom: 10px">
            <img src="/image/team/vladislav.jpg" class="img-div mate3"/>
            <h2>Vladislav Danilchick</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Back-end Developer, QA</p>
        </div>

        <div class="style-fourth" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <img src="/image/team/artyom.jpg" class="img-div mate4"/>
            <h2>Artyom Vasilevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Front-end Developer, QA</p>
        </div>

        <div class="style-fifth" style="padding-top: 50px; padding-bottom: 10px">
            <img src="/image/team/andrey.jpg" class="img-div mate5"/>
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
