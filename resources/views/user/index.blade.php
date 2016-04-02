@extends('layout')

@section('content')
<h2>ユーザ管理</h2>
<ul>
    <li><a href="{{action('UserController@getPassword')}}">パスワードの変更</a></li>
</ul>
@endsection