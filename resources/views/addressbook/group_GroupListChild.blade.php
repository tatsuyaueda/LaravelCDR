@if(array_key_exists('Child', $childGroups) && count($childGroups['Child']))
@foreach($childGroups['Child'] as $childGroup)
<tr class="treegrid-{{$childGroup['Id']}} treegrid-parent-{{$parent_groupid}}">
    <td>{{$childGroup['Name']}}</td>
    <td>
        <form method="post" action="{{action('AddressBookController@destroyGroup', $childGroup['Id'])}}">
            <a href="{{action('AddressBookController@getGroupEdit', $childGroup['Id'])}}" class="btn btn-default btn-xs">
                <i class="fa fa-edit"></i>
                編集
            </a>
            @if(!$childGroup['ItemCount'] and !count($childGroup['Child']))
            {!! csrf_field() !!}
            <input type="hidden" name="UserID" value="{{$childGroup['Id']}}" />
            <button type="button" class="btn btn-default btn-xs" onclick="delGroupConfirm($(this).parents('form')[0]);" >
                <i class="fa fa-times"></i>
                削除
            </button>
            <input type="hidden" name="_method" value="delete">
            @endif
        </form>
    </td>
</tr>
@include('addressbook.group_GroupListChild', ['childGroups' => $childGroup, 'parent_groupid' => $childGroup['Id']])
@endforeach
@endif
