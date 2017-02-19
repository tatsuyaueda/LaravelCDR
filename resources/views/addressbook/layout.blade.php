@extends('layout')

@section('title', 'Web電話帳')

@section('sidebar')
    <div class="main-sidebar">
        <div class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{$avater_image}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    @if(Auth::user()->AddressBook() && Auth::user()->AddressBook()->tel1)
                        <i class="fa fa-phone"></i>
                        {{ Auth::user()->AddressBook()->tel1 }}
                        <i class="myExtStatus extStatus ext{{ Auth::user()->AddressBook()->tel1 }}" title="不明"></i>
                        <script>
                            $(document).ready(function () {
                                var status  = extStatus['{{\Redis::GET('extStatus:' . Auth::user()->AddressBook()->tel1)}}'];
                                $('i.myExtStatus')
                                    .addClass(status['statusClass'])
                                    .attr('title', status['statusText']);
                            });
                        </script>
                    @endif
                </div>
            </div>

            <form action="#" method="get" class="sidebar-form" id="AddressBookSearch">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="検索...">
                    <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                class="fa fa-search"></i></button>
                </span>
                </div>
            </form>

            <ul class="sidebar-menu" id="TypeList">
                <li class="header">電話帳</li>
                @foreach($AddressBookType as $key => $value)
                    @include('addressbook.layout_GroupList', ['TypeName' => $value, 'TypeIndex' => $key])
                @endforeach
            </ul>

            <ul class="sidebar-menu">
                <li class="header">
                    <i class="fa fa-cog"></i> 管理
                </li>
                <li class="treeview">
                    <a href="{{action('AddressBookController@getEdit')}}">
                        <span>連絡先追加</span>
                    </a>
                </li>
                @permission('edit-addressbook')
                <li class="treeview">
                    <a href="{{action('AddressBookController@getGroup')}}">
                        <span>グループ管理</span>
                    </a>
                </li>
                @endpermission
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <section class="content-header">
        <h1>@yield('title')</h1>
    </section>
@endsection