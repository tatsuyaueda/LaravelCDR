@extends('layout')

@section('title', 'ログイン')

@section('content')
<section class="content">
    <div class="col-md-4 col-md-offset-4">
        <div class="box box-solid box-info">
            <div class="box-header">ログイン</div>
            <div class="box-body">
                @include('notification')

                <form class="form-signin" method="post" action="{{action('Auth\AuthController@postLogin')}}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="username" class="sr-only">ユーザ名</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="ユーザ名" required autofocus>
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
                    @if(Config::get('saml2_settings.useSaml2Auth'))
                        <a href="{{action('\Aacotroneo\Saml2\Http\Controllers\Saml2Controller@login')}}" class="btn btn-primary btn-block">SAML2でログイン</a>
                    @endif
                    <br />
                    <div class="text-center">
                        <a href="{{action('Auth\PasswordController@getEmail')}}">パスワードをお忘れですか？</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection