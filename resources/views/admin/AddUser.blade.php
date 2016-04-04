@extends('layout')

@section('content')
<h2>ユーザの追加</h2>
<div class="container-fluid">
    <div class="row">
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
        <div class="col-md-4">
            <form method="post" action="{{action('AdminController@postAddUser')}}">
                {!! csrf_field() !!}
                <label for="name" class="sr-only">ユーザ名</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="ユーザ名" value="{{old('name')}}" required autofocus>
                <label for="email" class="sr-only">メールアドレス</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレス"v alue="{{old('email')}}" required>
                <label for="password" class="sr-only">パスワード</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="パスワード" required>
                <label for="password_confirmation" class="sr-only">パスワード(確認)</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="パスワード(確認)" required>
                <br/>
                <button class="btn btn-primary" type="submit">変更</button>
            </form>
        </div>
    </div>
</div>
@endsection