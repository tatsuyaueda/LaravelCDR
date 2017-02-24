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
                    <div class="col-md-8">
                        @include('notification')

                        {!! csrf_field() !!}
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th width="150">
                                    <label for="inputUsername" class="control-label">ログインID</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="username" id="inputUsername"
                                           value="{{old('username', $record->username)}}" placeholder="ログインID" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th width="150">
                                    <label for="inputName" class="control-label">表示名</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="name" id="inputName"
                                           value="{{old('name', $record->name)}}" placeholder="表示名">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputEmail" class="control-label">メールアドレス</label>
                                </th>
                                <td>
                                    <input type="email" class="form-control input-sm" name="email" id="inputEmail"
                                           value="{{old('email', $record->email)}}" placeholder="メールアドレス">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" type="submit">変更</button>
                </div>
            </div>
            <input type="hidden" name="id" value="{{old('id', $record->id)}}">
        </form>
    </section>
@endsection