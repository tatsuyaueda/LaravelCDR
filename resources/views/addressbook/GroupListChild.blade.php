@if(array_key_exists('Child', $childGroups) && count($childGroups['Child']))
<ul class="treeview-menu">
    @foreach($childGroups['Child'] as $childGroup)
    <li>
        <a href="{{action('AddressBookController@getIndex')}}#{{$TypeIndex}}-{{$childGroup['Id']}}">
            {{$childGroup['Name']}}
            @if(array_key_exists('Child', $childGroup) && count($childGroup['Child']))
            <i class="fa fa-angle-left pull-right"></i>
            @endif
        </a>
        @include('addressbook.GroupListChild', ['childGroups' => $childGroup])
    </li>
    @endforeach
</ul>
@endif