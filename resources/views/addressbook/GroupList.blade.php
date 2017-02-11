<li class="treeview {{ $TypeIndex == 1 ? 'active' : '' }}">
    <a href="{{action('AddressBookController@getIndex')}}#{{$TypeIndex}}">
        <i class="fa fa-address-book"></i>
        <span>{{$TypeName}}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{action('AddressBookController@getIndex')}}#{{$TypeIndex}}-all">すべてを表示</a>
        </li>
        @if($groups != null && array_key_exists($TypeIndex, $groups) && is_array($groups[$TypeIndex]))
        @foreach($groups[$TypeIndex] as $group)
        <li>
            <a href="{{action('AddressBookController@getIndex')}}#{{$TypeIndex}}-{{$group['Id']}}">
                {{$group['Name']}}
                @if(array_key_exists('Child', $group) && count($group['Child']))
                <i class="fa fa-angle-left pull-right"></i>
                @endif
            </a>
            @include('addressbook.GroupListChild', ['childGroups' => $group])
        </li>
        @endforeach
        @endif
    </ul>
</li>