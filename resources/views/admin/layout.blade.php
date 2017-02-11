@extends('layout')

@section('title', 'システム管理')

@section('sidebar')
<div class="main-sidebar">
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">システム管理</li>
            <li class="treeview {{ 1 == 1 ? 'active' : '' }}">
                <a href="{{action('AdminController@getIndex')}}">
                    <span>ユーザ管理</span>
                </a>
        </ul>
    </div>
</div>
@endsection

@section('content')
<section class="content-header">
    <h1>@yield('title')</h1>
</section>
@endsection