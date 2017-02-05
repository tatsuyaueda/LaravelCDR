@extends('layout')

@section('content')
<div class="row">
    @if (Auth::guest())
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">PBX Tool</h3>
        </div>
        <div class="box-body">
            このサイトを利用するにはログインが必要です。<br />
            右上からログインしてください。
        </div>
    </div>
    @else
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">発着信履歴</h3>
            </div>
            <div class="box-body">
                発着信履歴の検索・表示が出来ます。
            </div>
        </div>
    </div>
      <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Web電話帳</h3>
            </div>
            <div class="box-body">
                内線・個人・共有電話帳の検索・表示が出来ます。
            </div>
        </div>
    </div>
    @endif
</div>
@endsection