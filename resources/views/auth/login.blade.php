@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">ログイン</div>
                <div class="panel-body">
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
                    <form class="form-signin" method="post" action="/auth/login">
                        {!! csrf_field() !!}
                        <label for="email" class="sr-only">メールアドレス</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレス" required autofocus>
                        <label for="password" class="sr-only">パスワード</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="パスワード" required>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember"> ログインを維持する
                            </label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
                    </form>
                </div
            </div>
        </div>
    </div>
</div>
@endsection