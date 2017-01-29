@extends('layout')

@section('content')
<div class="col-md-4 col-md-offset-4">
    <div class="box box-solid box-info">
        <div class="box-header">ログイン</div>
        <div class="box-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>エラー</strong><br />
                入力値に問題があります。<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="form-signin" method="post" action="{{action('Auth\AuthController@postLogin')}}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="email" class="sr-only">メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレス" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">パスワード</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="パスワード" required>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember"> ログインを維持する
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
                <br />
                <div class="text-center">
                    <a href="{{action('Auth\PasswordController@getEmail')}}">パスワードをお忘れですか？</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection