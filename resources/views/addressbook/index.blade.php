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
            @foreach($AddressBookType as $key => $value)
            @include('addressbook.GroupList', ['TypeName' => $value, 'TypeIndex' => $key])
            @endforeach
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
    <div id="resultLoading" style="visibility: hidden;" class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <div class="box-header with-border">
        <h3 class="box-title">電話帳一覧</h3>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper dt-bootstrap">
            <table class="table table-hover table-striped dataTable" id="AddressBookResult">
                <thead>
                    <tr>
                        <th>
                        </th>
                        <th>
                            役職/名前
                        </th>
                        <th>
                            連絡先
                        </th>
                        <th>
                            備考
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="searchTypeId" id="searchTypeId" value="" />
<input type="hidden" name="searchGroupId" id="searchGroupId" value="" />
<script>
<!--

    // 電話帳のグループ名がクリックされた場合
    $('.sidebar a').click(function (event) {
        // 子グループが存在する場合は処理しない
        if ($(this).children().is('i')) {
            return;
        }

        var list = $(this).attr('href').slice(1).split('-');

        $('input#searchTypeId').val(list[0]);
        $('input#searchGroupId').val(list[1]);
        $('#AddressBookResult').DataTable().draw();
    });

    // ドキュメントの準備ができた場合
    $(document).ready(function () {
        // DataTablesを初期化する
        $('#AddressBookResult')
                .on('processing.dt', function (e, settings, processing) {
                    // Loading spin
                    $('#resultLoading').css('visibility', processing ? 'visible' : 'hidden');
                })
                .DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Japanese.json"
                    },
                    dom: "<'row'<'col-sm-12'<'pull-right'l>>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    "order": [[0, "desc"]],
                    "processing": false,
                    "serverSide": true,
                    "searching": false,
                    "ajax": {
                        "url": "{{action('AddressBookController@postSearch')}}",
                        "type": "POST",
                        "data": function (d) {
                            d.typeId = $('#searchTypeId').val();
                            d.groupId = $('#searchGroupId').val();
                        }
                    },
                    "columns": [
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                return '<div class="image">' +
                                        '<img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&s=60" class="img-circle" alt="User Image">' +
                                        '</div>'
                            },
                            "width": "100px",
                        },
                        {
                            "data": "name",
                            "render": function (data, type, row) {
                                return '<small>' + row['position'] + '</small><br>' +
                                        '<a href="{{action('AddressBookController@getDetail')}}/' + row['id'] + '" class="modalShow" title="' + row['name_kana'] + '">' + data + '</a>';
                            },
                            "width": "250px",
                        },
                        {
                            "data": null,
                            "render": function (data, type, row) {
                                var buffer = '';
                                if (row['tel1'])
                                    buffer += '<i class="fa fa-phone"></i> <a href="tel:' + row['tel1'] + '">' + row['tel1'] + '</a> <i class="fa fa-circle text-success"></i><br/>';
                                if (row['tel2'])
                                    buffer += '<i class="fa fa-phone"></i> <a href="tel:' + row['tel2'] + '">' + row['tel2'] + '</a><br/>';
                                if (row['tel3'])
                                    buffer += '<i class="fa fa-phone"></i> <a href="tel:' + row['tel3'] + '">' + row['tel2'] + '</a><br/>';
                                if (row['email'])
                                    buffer += '<i class="fa fa-envelope"></i> <a href="mailto:' + row['email'] + '">' + row['email'] + '</a>';
                                return buffer;
                            },
                            "width": "300px",
                        },
                        {"data": "comment"},
                    ]
                });
    });
    //-->
</script>
@endsection