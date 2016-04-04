@extends('layout')

@section('content')
<h2>ユーザ管理</h2>

@if (Session::has('error_message'))
<div class="alert alert-danger">{{ Session::get('error_message') }}</div>
@elseif (Session::has('success_message'))
<div class="alert alert-success">{{ Session::get('success_message') }}</div>
@endif

<a href="{{action('AdminController@getAddUser')}}" class="btn btn-primary">ユーザ追加</a>

<p/>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>ユーザID</td>
            <td>ユーザ名</td>
            <td>ログイン名/メールアドレス</td>
            <td>操作</td>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td width="230">
                @if($user->id != 1)
                <!--
                <form method="post" action="/admin/">
                    {!! csrf_field() !!}
                    <input type="hidden" name="UserID" value="{{$user->id}}" />
                    <input type="submit" class="btn btn-default btn-xs" value="パスワード変更" />
                </form>
                -->
                <form method="post" action="/admin/DelUser">
                    {!! csrf_field() !!}
                    <input type="hidden" name="UserID" value="{{$user->id}}" />
                    <input type="submit" class="btn btn-default btn-xs" value="ユーザ削除" />
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection