<li class="treeview {{ $TypeIndex == 1 ? 'active' : '' }}">
    <a href="#{{$TypeIndex}}">
        <i class="fa fa-address-book"></i>
        <span>{{$TypeName}}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="#{{$TypeIndex}}-all">すべてを表示</a>
        </li>
        @if(array_key_exists($TypeIndex, $groups) && is_array($groups[$TypeIndex]))
        @foreach($groups[$TypeIndex] as $group)
        <li>
            <a href="#{{$TypeIndex}}-{{$group['Id']}}">
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