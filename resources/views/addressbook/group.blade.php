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
                                @if($GroupList != null && array_key_exists($key, $GroupList) && is_array($GroupList[$key]))
                                @foreach($GroupList[$key] as $group) 
                                <tr class="treegrid-{{$group->id}} {{$group->parent_groupid != 0 ? 'treegrid-parent-' . $group->parent_groupid : '' }}">
                                    <td>{{$group->group_name}}</td>
                                    <td>
                                        <a href="" class="btn btn-default btn-xs">
                                            <i class="fa fa-edit"></i>
                                            編集
                                        </a>
                                        <a href="" class="btn btn-default btn-xs">
                                            <i class="fa fa-times"></i>
                                            削除
                                        </a>
                                    </td>
                                </tr>
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
</script>
@endsection