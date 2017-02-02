@extends('layout')

@section('sidebar')
<div class="main-sidebar">
    <div class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在籍</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="検索...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="header">電話帳</li>
            <li class="active">
                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>内線電話帳</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>個人電話帳</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-address-book"></i>
                    <span>共有電話帳</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Web電話帳</h3>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">電話帳一覧</h3>
    </div>
    <div class="box-body">
        このサイトを利用するにはログインが必要です。<br />
        右上からログインしてください。
    </div>
</div>
@endsection