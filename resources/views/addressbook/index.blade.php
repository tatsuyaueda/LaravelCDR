@extends('addressbook.layout')

@section('content')
    @@parent
    <section class="content">
        <div class="box box-primary">
            <div id="resultLoading" style="visibility: hidden;" class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title">
                    電話帳一覧
                    <span id="breadcrumb" style="padding-left: 10px; color:gray; font-size:75%">
                    内線電話帳 > すべてを表示
                </span>
                    <span id="breadcrumbKeyword" style="color:gray; font-size:75%; visibility: hidden;">
                    > 検索結果
                </span>
                </h3>
            </div>
            <div class="box-body">
                @include('notification')

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
                            @permission('edit-addressbook')
                            <th>
                                操作
                            </th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="searchTypeId" id="searchTypeId" value="1"/>
    <input type="hidden" name="searchGroupId" id="searchGroupId" value="all"/>
    <input type="hidden" name="searchKeyword" id="searchKeyword" value=""/>
    <script>
        <!--

        function delConfirm(form) {
            bootbox.confirm("選択された連絡先を削除してもよろしいですか？", function (result) {
                if (result) {
                    form.submit();
                }
            });
        }

        // 検索
        $('form#AddressBookSearch').submit(function (event) {
            var keyword = $('form#AddressBookSearch input[name=keyword]').val();
            $('input#searchKeyword').val(keyword);

            // キーワードが入力されているかどうか
            $('span#breadcrumbKeyword').css('visibility', keyword.length !== 0 ? 'visible' : 'hidden');

            $('#AddressBookResult').DataTable().draw();
            return false;
        });

        // 電話帳のグループ名がクリックされた場合
        $('.sidebar #TypeList a').click(function (event) {
            // 子グループが存在する場合は処理しない
            if ($(this).children().is('i')) {
                return;
            }

            var list = $(this).attr('href').replace(/^.*?(#|$)/, '').split('-');

            // 現在、表示しているグループを取得
            var breadcrumb = '';

            $.each($(this).parents('li.active').children('a'), function (i, val) {
                breadcrumb = val.innerText + ' > ' + breadcrumb;
            });

            breadcrumb = breadcrumb + $(this).text();

            $('span#breadcrumb').text(breadcrumb);

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
                    "order": [[1, "asc"]],
                    "processing": false,
                    "serverSide": true,
                    "searching": false,
                    "ajax": {
                        "url": "{{action('AddressBookController@postSearch')}}",
                        "type": "POST",
                        "data": function (d) {
                            d.typeId = $('#searchTypeId').val();
                            d.groupId = $('#searchGroupId').val();
                            d.keyword = $('#searchKeyword').val();
                        }
                    },
                    "columns": [
                        {
                            "data": null,
                            "orderable": false,
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
                        {
                            "data": "comment",
                            "orderable": false,
                        },
                            @permission('edit-addressbook')
                        {
                            "data": null,
                            "orderable": false,
                            "width": "150px",
                            "render": function (data, type, row) {
                                var buffer = '';

                                buffer = '<form method="post" action="{{action('AddressBookController@destroyIndex')}}/' + row['id'] + '">' +
                                    '<a href="{{action('AddressBookController@getEdit')}}/' + row['id'] + '" class="btn btn-default btn-xs">' +
                                    '<i class="fa fa-edit"></i>' +
                                    '編集' +
                                    '</a>' +
                                    '{!! csrf_field() !!}' +
                                    '<input type="hidden" name="UserID" value="' + row['id'] + '" />' +
                                    '<button type="button" class="btn btn-default btn-xs" onclick="delConfirm($(this).parents(\'form\')[0]);" >' +
                                    '<i class="fa fa-times"></i>' +
                                    '削除' +
                                    '</button>' +
                                    '<input type="hidden" name="_method" value="delete">' +
                                    '</form>';

                                return buffer;
                            }
                        },
                        @endpermission
                    ]
                });
        });
        //-->
    </script>
@endsection