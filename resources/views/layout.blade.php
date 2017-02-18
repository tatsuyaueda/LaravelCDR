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
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Helvetica Neue', 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', '游ゴシック  Medium', meiryo, sans-serif;
        }
        /* 内線プレゼンス */
        i.extStatus::after {
            padding-left: 3px;
            font-size: 90%;
            color: #333;
            content: attr(title);
        }
    </style>
    <link rel="stylesheet" type="text/css" href="<?= elixir('css/app.css') ?>"/>
    <script>
        var extStatus = {
            'unknown' :{
                'statusClass': 'fa fa-circle text-gray',
                'statusText': '不明'
            },
            'idle': {
                'statusClass': 'fa fa-circle text-info',
                'statusText': 'アイドル'
            },
            'away': {
                'statusClass': 'fa fa-circle text-primary',
                'statusText': '不在'
            },
            'busy': {
                'statusClass': 'fa fa-circle text-danger',
                'statusText': '通話中'
            },
        };
    </script>
    <script src="<?= elixir('js/app.js') ?>" type="text/javascript"></script>
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
                        <li><a href="{{action('Auth\LoginController@login')}}">ログイン</a></li>
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
                                        <form method="post" action="{{action('Auth\LoginController@logout')}}">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-default btn-flat">ログアウト</button>
                                        </form>
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
<script type="text/javascript">
    <!--
    var laravelLogginUserID = '{{ Auth::guest() ? 0: Auth::user()->id }}';
    //-->
</script>
<!-- Laravel Echo -->
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
<script src="<?= elixir('js/echo.js') ?>" type="text/javascript"></script>

<!-- Original JavaScript -->
<script src="{{asset("js/select2_InitValue.js")}}" type="text/javascript"></script>
<script>
    <!--
    $(document).ready(function () {
        bootbox.setDefaults({
            locale: 'ja',
        });

        // PNotify オプション
        PNotify.prototype.options.styling = 'bootstrap3';

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