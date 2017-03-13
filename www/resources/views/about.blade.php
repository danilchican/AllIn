@extends('layouts.app')

@section('styles')
    <style>
        .about-info {
            padding-top: 25px;
            padding-bottom: 25px;
            text-align: center;
            color: #fff;
            background-color: #127cd0;
            font-size: 20px;
            font-style: inherit;
        }

        .team-info {
            padding-top: 10px;
            padding-bottom: 25px;
            text-align: center;
            color: inherit;
            background-color: inherit;
        }

        .team-info .mate {
            height: 175px;
            width: 175px;
            overflow: hidden;
            border-radius: 50%;
            position: relative;
            display: inline-block;
        }

        .team-info .mate > .mate1 {
            width: 178px;
            margin-top: -13px;
        }

        .team-info .mate > .mate2 {
            width: 540px;
            margin: -82px 0 0 -135px;
        }

        .team-info .mate > .mate3 {
            width: 340px;
            margin: -1px 0 0 -110px;
        }

        .team-info .mate > .mate4 {
            width: 695px;
            margin: -115px 0 0 -255px;
        }

        .mate5 {
            width: 180px;
            margin: -1px 0 0 -2px;
        }

    </style>
@endsection

@section('content')
    <div class="about-info">
        <h1>About us</h1>
        <p class="lead">Make your dreams come true with Allin<br> </p>

        AllInco — это онлайн сервис для Social Media Marketing (SMM),
        <br>который позволяет вам создавать, планировать
        <br>и размещать публикации в нескольких социальных сетях одновременно.
        <br>В данный момент AllInco имеет возможность делать публикации
        <br>и анализировать такие социальные сети, как Facebook и ВКонтакте.
        <br>Но мы планируем добавление других не менее популярных медиа.
    </div>
    <div class="team-info">
        <h1>Our team</h1>

        <div class="style-first" style="padding-top: 10px; padding-bottom: 10px">
            <div class="img-div mate">
                <img src="/image/team/alexandr.jpg" class="mate1" />
            </div>
            <h2>Alexandr Konikov</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Scrum Master</p>
        </div>

        <div class="style-second" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate">
                <img src="/image/team/ulyana.jpg" class="mate2" />
            </div>
            <h2>Ulyana Kiklevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Muse, Android Developer, QA</p>
        </div>

        <div class="style-third" style="padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate">
                <img src="/image/team/vladislav.jpg" class="mate3" />
            </div>
            <h2>Vladislav Danilchick</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Back-end Developer, QA</p>
        </div>

        <div class="style-fourth" style="background-color: white; padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate">
                <img src="/image/team/artyom.jpg" class="mate4" />
            </div>
            <h2>Artyom Vasilevich</h2>
            <p class="lead" style="font-style: italic; font-size: 18px">Front-end Developer, QA</p>
        </div>

        <div class="style-fifth" style="padding-top: 50px; padding-bottom: 10px">
            <div class="img-div mate">
                <img src="/image/team/andrey.png" class="mate5" />
            </div>
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
