@extends('layout')

@section('title', 'ユーザ情報')

@section('content')
<section class="content-header">
    <h1>@yield('title')</h1>
</section>
<section class="content">
    <form method="post" action="{{action('UserController@postPassword')}}">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    パスワードの変更
                </h3>
            </div>
            <div class="box-body">
                <div class="col-md-4">
                    @include('notification')
                    
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="old_password" class="sr-only">現在のパスワード</label>
                        <input type="password" id="old_password" name="old_password" class="form-control" placeholder="現在のパスワード" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="sr-only">新しいパスワード</label>
                        <input type="password" id="password" name="new_password" class="form-control" placeholder="新しいパスワード" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation" class="sr-only">新しいパスワード(確認)</label>
                        <input type="password" id="password" name="new_password_confirmation" class="form-control" placeholder="新しいパスワード(確認)" required>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">変更</button>
            </div>  
        </div>
    </form>
</section>
@endsection