@extends('layout')

@section('title', 'Web電話帳')

@section('sidebar')
<div class="main-sidebar">
    <div class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-gray"></i> 在籍</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form" id="AddressBookSearch">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="検索...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="header">電話帳</li>
            @foreach($AddressBookType as $key => $value)
            @include('addressbook.GroupList', ['TypeName' => $value, 'TypeIndex' => $key])
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('content')
<section class="content-header">
    <h1>@yield('title')</h1>
</section>
@endsection