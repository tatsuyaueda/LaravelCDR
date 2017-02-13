@extends('addressbook.layout')

@section('content')
@@parent
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{action('AddressBookController@postGroupEdit', old('id', $record->id))}}">
                {!! csrf_field() !!}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            グループ編集
                        </h3>
                    </div>
                    <div class="box-body">
                        @include('notification')

                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="150">
                                        <label for="inputId" class="control-label">グループID</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="id" id="inputId" value="{{old('id', $record->id)}}" placeholder="グループID" readonly="readonly">
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
                                        <label for="inputGroup" class="control-label">親グループ</label>
                                    </th>
                                    <td>
                                        <select class="form-control input-sm" name="parent_groupid" id="inputGroup">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="inputName" class="control-label">名前</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control input-sm" name="group_name" id="inputName" value="{{old('group_name', $record->group_name)}}" placeholder="名前" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">保存</button>
                    </div>
                </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('select[name=type]').select2({
            minimumResultsForSearch: Infinity
        });
        
        var $select2grp = $('select[name=parent_groupid]')
                .select2({
                    ajax: {
                        url: '{{action('AddressBookController@getSel2Group')}}',
                        dataType: 'json',
                        data:  function (term, page) {
                            return {
                                type: $('select[name=type]').val(),
                                from: 'GroupEdit'
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
                    templateResult: function (node) {
                        return $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
                    }
                });
                
                select2_InitValue($select2grp, '{{action('AddressBookController@getSel2Group')}}', {type: {{old('type', $record->type)}}} , {{old('parent_groupid', $record->parent_groupid)}});
                
    });
</script>
@endsection