@extends('layouts.app')

@section('head')
    <title>Личный кабинет</title>
@endsection

@section('styles')
    <style>
        .main-row {
            margin-top: 40px;
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
    <div class="container" id="app">
        @if(Session::has('message'))
            <p class="alert alert-info" style="margin-top:40px">{{ Session::get('message') }}</p>
        @endif
        <div class="main-row">
            <div class="col-md-3">
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