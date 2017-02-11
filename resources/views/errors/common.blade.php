@extends('layout')
@section('title', 'Error')

@section('content')
<?php
$status_code = $exception->getStatusCode();
$error_msg = $exception->getMessage();

switch ($status_code) {
    case 400:
        $message = 'Bad Request';
        break;
    case 401:
        $message = '認証に失敗しました';
        break;
    case 403:
        $message = 'アクセス権がありません';
        break;
    case 404:
        $message = '存在しないページです';
        break;
    case 408:
        $message = 'タイムアウトです';
        break;
    case 414:
        $message = 'リクエストURIが長すぎます';
        break;
    case 500:
        $message = 'Internal Server Error';
        break;
    case 503:
        $message = 'Service Unavailable';
        break;
    default:
        $message = 'エラー';
        break;
}
?>
<section class="content-header">
    <h1>
        {{$status_code}} Error Page
    </h1>
</section>

<section class="content">
    <div class="error-page">
        <h2 class="headline text-red">{{$status_code}} </h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{$message}}</h3>
            <p>
                {{$error_msg}}
            </p>
        </div>
    </div>
</section>
@endsection