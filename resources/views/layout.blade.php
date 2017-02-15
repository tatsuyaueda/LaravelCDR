<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>{{trim($__env->yieldContent('title')) ? $__env->yieldContent('title') . ' - ' : '' }}PBX Tool</title>
    <title>PBX Tool</title>
    <!-- for responsive -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css"
          href="{{asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}"/>
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- ionicons -->
    <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
    <!-- adminLTE style -->
    <link rel="stylesheet" type="text/css" href="{{asset("bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset("bower_components/AdminLTE/dist/css/skins/skin-blue-light.min.css")}}">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.bootstrap.min.css">
    <!-- DateRange Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>
    <!-- TreeGrid -->
    <link rel="stylesheet" type="text/css"
          href="{{asset('bower_components/jquery-treegrid/css/jquery.treegrid.css')}}"/>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Helvetica Neue', 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', '游ゴシック  Medium', meiryo, sans-serif;
        }
    </style>
    <script src="{{asset("bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js")}}"
            type="text/javascript"></script>
</head>
{{-- サイドバーの有無を確認 --}}
<body class="skin-blue-light {{ trim($__env->yieldContent('sidebar')) ? 'sidebar-mini' : 'sidebar-collapse'}}">
<div class="wrapper">
    <header class="main-header">
        <a href="{{url('/')}}" class="logo">
                    <span class="logo-mini">
                        P
                    </span>
            <span class="logo-lg">
                        PBX Tool
                    </span>
        </a>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm"
                                     class="user-image" alt="User Image">
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm"
                                         class="img-circle" alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }}
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    @role('admin')
                                    <div class="col-xs-12 text-center">
                                        <a href="{{action('AdminController@getIndex')}}">ユーザ管理</a>
                                    </div>
                                    @endif
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{action('UserController@getPassword')}}"
                                           class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{action('Auth\AuthController@getLogout')}}"
                                           class="btn btn-default btn-flat">ログアウト</a>
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
        @yield('content')
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">Version 1.0</div>
        <strong>Copyright &copy; 2017 PBX Tool.</strong>, All rights reserved.
    </footer>
</div>

<div id="modalDetail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                </h4>
            </div>
            <div class="modal-body">
                <div id="modal-loader" style="display: none; text-align: center;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="dynamic-content"></div>
            </div>
            <div class="modal-footer">
                        <span class="dynamic-content">

                        </span>
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap -->
<script src="{{asset("bower_components/AdminLTE/bootstrap/js/bootstrap.min.js")}}"
        type="text/javascript"></script>
<!-- AdminLTE -->
<script src="{{asset("bower_components/AdminLTE/dist/js/app.min.js")}}" type="text/javascript"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<!-- BootBox -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<!-- Moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/ja.js"></script>
<!-- Toastr -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- DataRange Picker -->
<script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<!-- Select2 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/ja.js"></script>
<!-- TreeGrid -->
<script src="{{asset("bower_components/jquery-treegrid/js/jquery.treegrid.min.js")}}"
        type="text/javascript"></script>
<script src="{{asset("bower_components/jquery-treegrid/js/jquery.treegrid.bootstrap3.js")}}"
        type="text/javascript"></script>
<!-- Original JavaScript -->
<script src="{{asset("js/select2_InitValue.js")}}" type="text/javascript"></script>

<script>
    <!--
    $(document).ready(function () {
        bootbox.setDefaults({
            locale: 'ja',
        });

        // toastr オプション
        toastr.options.closeButton = true;

        $.fn.select2.defaults.set('lang', 'ja');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // Async Post
    $(document).on('submit', 'form[data-async]', function (event) {
        var $form = $(this);

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function (data, status) {
                toastr.success(data.message, data.title);
            },
            error: function (data, status) {
                toastr.error(data.message, data.title);
            }
        });

        event.preventDefault();
    });

    // Modal Show
    $(document).on('click', 'a.modalShow', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $('#modalDetail .modal-header .modal-title').html('');
        $('#modalDetail .modal-body .dynamic-content').html('');
        $('#modalDetail .modal-footer .dynamic-content').html('');

        $('#modal-loader').show();
        $('#modalDetail').modal('show');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
            .done(function (data) {
                // タイトル
                $('#modalDetail .modal-header .modal-title')
                    .html($(data).filter('title').text());

                // コンテンツ
                $('#modalDetail .modal-body .dynamic-content')
                    .html($(data).filter('section.body').html());

                // カスタムフッター
                if ($(data).filter('section.footer').length !== 0) {
                    $('#modalDetail .modal-footer .dynamic-content').html($(data).filter('section.footer').html());
                }

                $('#modal-loader').hide();
            })
            .fail(function () {
                $('#modalDetail .modal-body .dynamic-content')
                    .html('<i class="glyphicon glyphicon-info-sign"></i>エラーが発生しました。');
                $('#modal-loader').hide();
            });
    });
    //-->
</script>
</body>
</html>