<li class="treeview">
    <a href="#a">
        <i class="fa fa-address-book"></i>
        <span>{{$TypeName}}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="#">
                グループ無し
            </a>
        </li>
        <!--// 1階層目 -->
        @if(array_key_exists($TypeIndex, $groups) && is_array($groups[$TypeIndex]))
        @foreach($groups[$TypeIndex] as $group)
        <li>
            <a href="#{{$group['Id']}}">
                {{$group['Name']}}
                @if(array_key_exists('Child', $group) && count($group['Child']))
                <i class="fa fa-angle-left pull-right"></i>
                @endif
            </a>
            @if(array_key_exists('Child', $group))
            <ul class="treeview-menu">
                <!--// 2階層目 -->
                @foreach($group['Child'] as $childGroup)
                <li>
                    <a href="#{{$childGroup['Id']}}">
                        {{$childGroup['Name']}}
                        @if(array_key_exists('Child', $childGroup) && count($childGroup['Child']))
                        <i class="fa fa-angle-left pull-right"></i>
                        @endif
                    </a>
                    @if(array_key_exists('Child', $childGroup) && count($childGroup['Child']))
                    <ul class="treeview-menu">
                        <!--// 3階層目 -->
                        @foreach($childGroup['Child'] as $grandsonGroup)
                        <li>
                            <a href="#{{$grandsonGroup['Id']}}">{{$grandsonGroup['Name']}}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
        @endif
    </ul>
</li>