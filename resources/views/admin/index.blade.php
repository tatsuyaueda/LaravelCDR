@extends('admin.layout')

@section('content')
@@parent
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">ユーザ管理</h3>
        </div>
        <div class="box-body">
            @include('notification')

            <a href="{{action('AdminController@getAddUser')}}" class="btn btn-primary">ユーザ追加</a>

            <p/>
            <div class="dataTables_wrapper dt-bootstrap">
                <table class="table table-bordered table-striped dataTables">
                    <thead>
                        <tr>
                            <td>ユーザID</td>
                            <td>ユーザ名</td>
                            <td>表示名</td>
                            <td>メールアドレス</td>
                            <td>ロール</td>
                            <td>操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                <span class="label label-success">{{$role->display_name}}</span>
                                @endforeach
                            </td>
                            <td width="230">
                                @if($user->username != 'admin')
                                <!--
                                <form method="post" action="/admin/">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="UserID" value="{{$user->id}}" />
                                    <input type="submit" class="btn btn-default btn-xs" value="パスワード変更" />
                                </form>
                                -->
                                <form method="post" action="{{action('AdminController@postDelUser')}}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="UserID" value="{{$user->id}}" />
                                    <input type="button" class="btn btn-default btn-xs" value="ユーザ削除" onclick="delUserConfirm($(this).parents('form')[0]);" />
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script>
    <!--
    function delUserConfirm(form) {
        bootbox.confirm("選択されたユーザを削除してもよろしいですか？", function (result) {
            if (result) {
                form.submit();
            }
        });
    }
    //-->    
</script>
@endsection