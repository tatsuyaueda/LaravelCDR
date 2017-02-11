@extends('layout')

@section('title', 'パスワードリセット')

@section('content')
<section class="content">
    <div class="col-md-4 col-md-offset-4">
        <div class="box box-solid box-info">
            <div class="box-header">パスワードリセット</div>
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

                <form method="POST" action="{{action('Auth\PasswordController@postReset')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email" class="sr-only">メールアドレス</label>
                        <input type="email" class="form-control" name="email" placeholder="メールアドレス" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password" class="sr-only">パスワード</label>
                        <input type="password" class="form-control" name="password" placeholder="パスワード" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">パスワード(確認)</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="パスワード(確認)" required>
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">パスワードをリセットする</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
