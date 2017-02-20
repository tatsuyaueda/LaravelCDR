@extends('user.layout')

@section('content')
    @@parent
    <section class="content">
        <form method="post" action="{{action('UserController@postIndex')}}">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        ユーザ情報
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        @include('notification')
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">変更</button>
                </div>
            </div>
        </form>
    </section>
@endsection