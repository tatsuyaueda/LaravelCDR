<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>発着信履歴</title>
        <!-- for responsive -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- bootstrap -->
        <link href="{{asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- font awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- adminLTE style -->
        <link href="{{asset("bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("bower_components/AdminLTE/dist/css/skins/skin-blue-light.min.css")}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Helvetica Neue', 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', '游ゴシック  Medium', meiryo, sans-serif;
            }
        </style>
        <script src="{{asset("bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.3.min.js")}}" type="text/javascript"></script>
    </head>
    <body class="skin-blue-light sidebar-collapse ">
        <div class="wrapper">
            <!-- トップメニュー -->
            <header class="main-header">
                <!-- ロゴ -->
                <a href="{{url('/')}}" class="logo">発着信履歴</a>

                <!-- トップメニュー -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::segment(1) === 'cdr' ? 'active' : null }}">
                            <a href="{{action('CdrController@getIndex')}}">履歴表示</a>
                        </li>
                    </ul>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            @if (Auth::guest())
                            <li><a href="{{action('Auth\AuthController@getLogin')}}">ログイン</a></li>
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{action('UserController@getPassword')}}">パスワードの変更</a></li>
                                    @if (Auth::User()->id == 1)
                                    <li><a href="{{action('AdminController@getIndex')}}">ユーザ管理</a></li>
                                    @endif
                                    <li><a href="{{action('Auth\AuthController@getLogout')}}">ログアウト</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </header><!-- end header -->

            <div class="content-wrapper">
                <section class="content">   
                    @yield('content')
                </section>
            </div>

            <!-- フッター -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">Version1.0</div>
                <strong>Copyright &copy; 2017 TATSUYA.info</strong>, All rights reserved.
            </footer>
        </div>

        <script src="{{asset("bower_components/AdminLTE/bootstrap/js/bootstrap.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("bower_components/AdminLTE/dist/js/app.min.js")}}" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/ja.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script>
<!--
bootbox.setDefaults({
    locale: 'ja',
});
//-->
        </script>
    </body>
</html>