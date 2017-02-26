@extends('layouts.app')

@section('head')
    <title>Личный кабинет</title>
@endsection

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-3">
                <ul class="list-group">
                    <router-link to="/home" class="list-group-item" exact>Личный кабинет</router-link>
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