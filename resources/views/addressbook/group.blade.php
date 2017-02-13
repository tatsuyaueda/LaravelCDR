@extends('addressbook.layout')

@section('content')
@@parent
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                グループ管理
            </h3>
        </div>
        <div class="box-body">
            @include('notification')

            <a href="{{action('AddressBookController@getGroupEdit')}}" class="btn btn-default">
                <i class="fa fa-plus"></i>
                グループの追加
            </a>
            <p/>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($AddressBookType as $key => $value)
                    <li class="{{ $key == 1 ? 'active' : '' }}"><a href="#tab_{{$key}}" data-toggle="tab" aria-expanded="true">{{$value}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($AddressBookType as $key => $value)
                    <div class="tab-pane {{ $key == 1 ? 'active' : '' }}" id="tab_{{$key}}">
                        <table class="table table-condensed table-striped tree">
                            <thead>
                                <tr>
                                    <th>グループ名</th>
                                    <th width="200">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($Groups != null && array_key_exists($key, $Groups) && is_array($Groups[$key]))
                                @foreach($Groups[$key] as $group)
                                <tr class="treegrid-{{$group['Id']}}">
                                    <td>{{$group['Name']}}</td>
                                    <td>
                                        <form method="post" action="{{action('AddressBookController@destroyGroup', $group['Id'])}}">
                                            <a href="{{action('AddressBookController@getGroupEdit', $group['Id'])}}" class="btn btn-default btn-xs">
                                                <i class="fa fa-edit"></i>
                                                編集
                                            </a>
                                            @if(!$group['ItemCount'] and !count($group['Child']))
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="UserID" value="{{$group['Id']}}" />
                                            <button type="button" class="btn btn-default btn-xs" onclick="delGroupConfirm($(this).parents('form')[0]);" >
                                                <i class="fa fa-times"></i>
                                                削除
                                            </button>
                                            <input type="hidden" name="_method" value="delete">
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @include('addressbook.group_GroupListChild', ['childGroups' => $group, 'parent_groupid' => $group['Id']])
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('table.tree').treegrid();
    });

    function delGroupConfirm(form) {
        bootbox.confirm("選択されたグループを削除してもよろしいですか？", function (result) {
            if (result) {
                form.submit();
            }
        });
    }
    //-->
</script>
@endsection