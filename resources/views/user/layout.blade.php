@extends('layout')

@section('title', 'ユーザ管理')

@section('sidebar')
    <div class="main-sidebar">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="header">ユーザ管理</li>
                <li class="treeview {{ Request::segment(2) === null ? 'active' : null }}">
                    <a href="{{action('UserController@getIndex')}}">
                        <span>ユーザ情報</span>
                    </a>
                </li>
                @if(Auth::user()->AddressBook())
                <li class="treeview {{ Request::segment(2) === 'addressbook' ? 'active' : null }}">
                    <a href="{{action('UserController@getAddressBook')}}">
                        <span>内線電話帳情報</span>
                    </a>
                </li>
                @endif
                <li class="treeview {{ Request::segment(2) === 'password' ? 'active' : null }}">
                    <a href="{{action('UserController@getPassword')}}">
                        <span>パスワードの変更</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <section class="content-header">
        <h1>@yield('title')</h1>
    </section>
@endsection