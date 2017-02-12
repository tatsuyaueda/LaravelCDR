@extends('addressbook.layout')

@section('content')
@@parent
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{action('AddressBookController@postEdit', old('id', $record->id))}}">
                {!! csrf_field() !!}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            電話帳を追加する
                        </h3>
                    </div>
                    <div class="box-body">
                        @include('notification')

                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="150">
                                        <label for="inputId" class="control-label">アドレス帳ID</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="id" id="inputId" value="{{old('id', $record->id)}}" placeholder="アドレス帳ID" readonly="readonly">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputPosition" class="control-label">役職</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="position" id="inputPosition" value="{{old('position', $record->position)}}" placeholder="役職">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputNameKana" class="control-label">名前(カナ)</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="name_kana" id="inputNameKana" value="{{old('name_kana', $record->name_kana)}}" placeholder="名前(カナ)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputName" class="control-label">名前</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="name" id="inputName" value="{{old('name', $record->name)}}" placeholder="名前">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputType" class="control-label">電話帳種別</label>
                                    </th>
                                    <td>
                                        <select class="form-control input-sm" name="type" id="inputType">
                                            @foreach($editAddressBookType as $key => $value)
                                            @if($key == old('type', $record->type))
                                            <option value="{{$key}}" selected="selected">{{$value}}</option>
                                            @else
                                            <option value="{{$key}}">{{$value}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputGroup" class="control-label">所属グループ</label>
                                    </th>
                                    <td>
                                        <select class="form-control input-sm" name="groupid" id="inputGroup">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputTel1" class="control-label">電話番号1</label>
                                    </th>
                                    <td>
                                        <input type="tel" class="form-control input-sm" name="tel1" id="inputTel1" value="{{old('tel1', $record->tel1)}}" placeholder="電話番号1">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputTel2" class="control-label">電話番号2</label>
                                    </th>
                                    <td>
                                        <input type="tel" class="form-control input-sm" name="tel2" id="inputTel2" value="{{old('tel2', $record->tel2)}}" placeholder="電話番号2">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputTel3" class="control-label">電話番号3</label>
                                    </th>
                                    <td>
                                        <input type="tel" class="form-control input-sm" name="tel3" id="inputTel3" value="{{old('tel3', $record->tel3)}}" placeholder="電話番号3">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputEmail" class="control-label">メールアドレス</label>
                                    </th>
                                    <td>
                                        <input type="email" class="form-control input-sm" name="email" id="inputEmail" value="{{old('email', $record->email)}}" placeholder="メールアドレス">
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputComment" class="control-label">備考</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="comment" id="inputComment" value="{{old('comment', $record->comment)}}" placeholder="備考">
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
</section>
<script>
<!--
    $(document).ready(function () {

        $('select[name=type]').select2({
            minimumResultsForSearch: Infinity,
        });
        
        var $select2grp = $('select[name=groupid]')
                .select2({
                    ajax: {
                        url: '{{action('AddressBookController@getSel2Group')}}',
                        dataType: 'json',
                        data:  function () {
                            return {
                                type: $('select[name=type]').val()
                            };
                        },
                        processResults: function (data, params) {
                            return {
                                results: data,
                            };
                        },
                        cache: true,
                    },
                    minimumResultsForSearch: Infinity,
                    templateResult: formatResult,
                });
                
                //if

        var $option = $('<option selected>読み込み中...</option>').val("{{old('group', $record->group)}}");
        $select2grp.append($option).trigger('change');

         $.ajax({
            type: 'GET',
                    url: '{{action('AddressBookController@getSel2Group')}}',
                    dataType: 'json',
                    data: {
                            type: $('select[name=type]').val(), // search term
                        },
                    success:function (data) {
                        var filtered = $.grep(data,
                            function(elem, index) {
                                return (elem.id == "{{old('group', $record->groupid)}}");
                            }
                        );
                        
                $option.text(filtered[0].text).val(filtered[0].id);
                $option.removeData();
                $select2grp.trigger('change');
            }
        });
    });
    function formatResult(node) {
        var $result = $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
        return $result;
    }
    //-->
</script>
@endsection