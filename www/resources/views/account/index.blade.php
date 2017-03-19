@extends('layouts.app')

@section('head')
    <title>Личный кабинет</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/toastr.css">
    <style>
        .main-row {
            margin-top: 40px;
        }

        .user-info {
            background-color: white;
            border-radius: 4px;
            border: 1px solid #d3e0e9;
            alignment: center;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 10px;
        }
    </style>

    <script>
        // Remove # sign after facebook login
        if ( (location.hash == "#_=_" || location.href.slice(-1) == "#_=_") ) {
            removeHash();
        }

        function removeHash() {
            var scrollV, scrollH, loc = window.location;
            if ('replaceState' in history) {
                history.replaceState('', document.title, loc.pathname + loc.search);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;

                loc.hash = '';

                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }
    </script>
@endsection

@section('content')
    <div class="container" id="app" style="background-color: #edeef0;">
        @if(Session::has('message'))
            <p class="alert alert-info" style="margin-top:40px">{{ Session::get('message') }}</p>
        @endif
        <div class="main-row">
            <div class="col-md-3">
                <div class="user-info">
                    <h4 style="margin-top:0;">{{ $user->name }}</h4>

                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="User photo" style="max-width: 200px;" />
                    @else
                        <img src="/image/no_avatar.jpg" alt="User photo" style="max-width: 200px;" />
                    @endif
                </div>

                <ul class="list-group">
                    <router-link to="/home" class="list-group-item" exact>
                        <i class="fa fa-btn fa-user-circle-o"></i> Home
                    </router-link>

                    <router-link to="/home/post" class="list-group-item" exat>
                        <i class="fa fa-btn fa-pencil-square-o"></i> Post
                    </router-link>

                    <router-link to="/home/calendar" class="list-group-item" exat>
                        <i class="fa fa-btn fa-calendar-o"></i> Calendar
                    </router-link>

                    <router-link to="/home/statistics" class="list-group-item" exat>
                        <i class="fa fa-btn fa-area-chart"></i> Statistics
                    </router-link>

                    <router-link to="/home/accounts" class="list-group-item" exat>
                        <i class="fa fa-btn fa-users"></i> Accounts
                    </router-link>

                    <router-link to="/home/settings" class="list-group-item" exat>
                        <i class="fa fa-btn fa-cogs"></i> Settings
                    </router-link>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <router-view class="view"></router-view>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/account.js"></script>
@endsection