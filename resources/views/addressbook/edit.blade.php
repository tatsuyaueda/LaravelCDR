@extends('addressbook.layout')

@section('content')
@@parent
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="POST" action="{{action('AddressBookController@postEdit')}}">
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        電話帳を追加する
                    </h3>
                </div>
                <div class="box-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>エラー</strong><br />
                        入力値に問題があります。<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="150">
                                    <label for="inputId" class="control-label">アドレス帳ID</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="id" id="inputId" value="{{$record->id}}" placeholder="アドレス帳ID" readonly="readonly">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputPosition" class="control-label">役職</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="position" id="inputPosition" value="{{$record->position}}" placeholder="役職">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputNameKana" class="control-label">名前(カナ)</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="name_kana" id="inputNameKana" value="{{$record->name_kana}}" placeholder="名前(カナ)">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputName" class="control-label">名前</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="name" id="inputName" value="{{$record->name}}" placeholder="名前">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="id" class="control-label">電話帳種別</label>
                                </th>
                                <td>
                                    <select class="form-control input-sm">
@foreach($AddressBookType as $key => $value)
<option value="{{$key}}">{{$value}}</option>
@endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="id" class="control-label">所属グループ</label>
                                </th>
                                <td>
                                    <select class="form-control input-sm">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputTel1" class="control-label">電話番号1</label>
                                </th>
                                <td>
                                    <input type="tel" class="form-control input-sm" name="tel1" id="inputTel1" value="{{$record->tel1}}" placeholder="電話番号1">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputTel2" class="control-label">電話番号2</label>
                                </th>
                                <td>
                                    <input type="tel" class="form-control input-sm" name="tel2" id="inputTel2" value="{{$record->tel2}}" placeholder="電話番号2">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputTel3" class="control-label">電話番号3</label>
                                </th>
                                <td>
                                    <input type="tel" class="form-control input-sm" name="tel3" id="inputTel3" value="{{$record->tel3}}" placeholder="電話番号3">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputEmail" class="control-label">メールアドレス</label>
                                </th>
                                <td>
                                    <input type="email" class="form-control input-sm" name="email" id="inputEmail" value="{{$record->email}}" placeholder="メールアドレス">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="inputComment" class="control-label">備考</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control input-sm" name="comment" id="inputComment" value="{{$record->comment}}" placeholder="備考">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection