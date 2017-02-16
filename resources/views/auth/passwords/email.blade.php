@extends('layout')

@section('title', 'パスワードリセット')

@section('content')
<section class="content">
    <div class="col-md-4 col-md-offset-4">
        <div class="box box-solid box-info">
            <div class="box-header">パスワードリセット</div>
            <div class="box-body">
                {{-- フレームワーク側で status にセットされているため、共通化出来ない --}}
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                
                @include('notification')

                <form method="POST" action="{{action('Auth\ForgotPasswordController@sendResetLinkEmail')}}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="email" class="sr-only">メールアドレス</label>
                        <input type="email" class="form-control" name="email" placeholder="メールアドレス" value="{{ old('email') }}" required autofocus>
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">パスワードリセットを行う</button>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection