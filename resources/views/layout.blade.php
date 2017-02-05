<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @if (trim($__env->yieldContent('title')))
        <title>@yield('title') - PBX Tool</title>
        @else
        <title>PBX Tool</title>
        @endif
        <!-- for responsive -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- bootstrap -->
        <link href="{{asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- font awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
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
        <script src="{{asset("bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js")}}" type="text/javascript"></script>
    </head>
    @if (trim($__env->yieldContent('sidebar')))
    <body class="skin-blue-light sidebar-mini">
        @else
    <body class="skin-blue-light sidebar-collapse">
        @endif
        <div class="wrapper">
            <!-- トップメニュー -->
            <header class="main-header">
                <!-- ロゴ -->
                <a href="{{url('/')}}" class="logo">
                    <span class="logo-mini">
                        P
                    </span>
                    <span class="logo-lg">
                        PBX Tool
                    </span>
                </a>
                <!-- トップメニュー -->
                <nav class="navbar navbar-static-top" role="navigation">
                    @if (trim($__env->yieldContent('sidebar')))
                    <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    @endif
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::segment(1) === 'cdr' ? 'active' : null }}">
                            <a href="{{action('CdrController@getIndex')}}">発着信履歴</a>
                        </li>
                        <li class="{{ Request::segment(1) === 'addressbook' ? 'active' : null }}">
                            <a href="{{action('AddressBookController@getIndex')}}">Web電話帳</a>
                        </li>
                    </ul>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            @if (Auth::guest())
                            <li><a href="{{action('Auth\AuthController@getLogin')}}">ログイン</a></li>
                            @else
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" class="user-image" alt="User Image">
                                    {{ Auth::user()->name }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" class="img-circle" alt="User Image">
                                        <p>
                                            {{ Auth::user()->name }}
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        @if (Auth::User()->id == 1)
                                        <div class="col-xs-12 text-center">
                                            <a href="{{action('AdminController@getIndex')}}">ユーザ管理</a>
                                        </div>
                                        @endif
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{action('UserController@getPassword')}}" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{action('Auth\AuthController@getLogout')}}" class="btn btn-default btn-flat">ログアウト</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </header>

            @yield('sidebar')

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

        <div id="modalDetail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">
                            <i class="glyphicon glyphicon-user"></i> 詳細情報
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal-loader" style="display: none; text-align: center;">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                        <div id="dynamic-content"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
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
$(document).ready(function () {
    bootbox.setDefaults({
        locale: 'ja',
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// Modal Show
$(document).on('click', 'a.modalShow', function (e) {
    e.preventDefault();

    var url = $(this).attr('href');

    $('#dynamic-content').html('');
    $('#modal-loader').show();
    $('#modalDetail').modal('show');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html'
    })
            .done(function (data) {
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data);
                $('#modal-loader').hide();
            })
            .fail(function () {
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i>エラーが発生しました。');
                $('#modal-loader').hide();
            });
});
//-->
        </script>
    </body>
</html>