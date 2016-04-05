@extends('layout')

@section('content')
<div class="panel-group" id="accordion" role="tablist">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="search">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#search" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <span class="glyphicon glyphicon-search"></span>
                    検索条件
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="search">
            <div class="panel-body">
                <form class="form-horizontal" id="searchForm" action="JavaScript:return false;">
                    <div class="form-group">
                        <label for="col4_filter" class="col-sm-1 control-label">発信者：</label>
                        <div class="col-sm-4">
                            <input type="text" class="column_filter" id="col4_filter" data-column="4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="col5_filter" class="col-sm-1 control-label">着信先：</label>
                        <div class="col-sm-4">
                            <input type="text" class="column_filter" id="col5_filter" data-column="5">
                        </div>
                        <div class="col-sm-offset-10">
                            <button class="btn btn-default" type="reset">
                                <span class="glyphicon glyphicon-remove"></span>
                                条件をクリアする
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<table class="table table-bordered table-condensed table-striped" id="view">
    <thead>
        <tr>
            <th>通話開始時間</th>
            <th>通話終了時間</th>
            <th>通話時間</th>
            <th>種別</th>
            <th>発信者</th>
            <th>着信先</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script>
<!--

    function toHms(t) {
        var hms = "";
        var h = t / 3600 | 0;
        var m = t % 3600 / 60 | 0;
        var s = t % 60;

        if (h != 0) {
            hms = h + "時間" + padZero(m) + "分" + padZero(s) + "秒";
        } else if (m != 0) {
            hms = m + "分" + padZero(s) + "秒";
        } else {
            hms = s + "秒";
        }

        return hms;

        function padZero(v) {
            if (v < 10) {
                return "0" + v;
            } else {
                return v;
            }
        }
    }

    var formatDate = function (date, format) {
        if (!format)
            format = 'YYYY/MM/DD hh:mm:ss';
        format = format.replace(/YYYY/g, date.getFullYear());
        format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
        format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
        format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
        format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
        format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
        if (format.match(/S/g)) {
            var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
            var length = format.match(/S/g).length;
            for (var i = 0; i < length; i++)
                format = format.replace(/S/, milliSeconds.substring(i, i + 1));
        }
        return format;
    };

    $(document).ready(function () {

        // 検索条件のクリア
        $('#searchForm button:reset').click(function (event) {
            event.preventDefault();

            $(this).parents('form').find(':text').val("");

            $('#view').DataTable().search('')
                    .columns().search('')
                    .draw();
        });

        // 検索条件が変更された場合
        $('input.column_filter').on('change', function () {
            var columnNo = $(this).attr('data-column');
            
            $('#view').DataTable().column(columnNo).search(
                $('#col' + columnNo + '_filter').val(),
                true,
                true
                ).draw();
        });

        $('#view').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Japanese.json"
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'<'pull-right'l>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'csvHtml5'
            ],
            "order": [[ 0, "desc" ]],
            "processing": false,
            "serverSide": true,
            "searching": true,
            "ajax": {
                "url": "{{action('CdrController@postSearch')}}",
                "type": "POST"
            },
            "columns": [
                {
                    "data": "StartDateTime",
                    "render": function (data) {
                        return formatDate(new Date(data));
                    }
                },
                {
                    "data": "EndDateTime",
                    "render": function (data) {
                        return formatDate(new Date(data));
                    }
                },
                {
                    "data": "Duration",
                    "render": function (data) {
                        return toHms(data);
                    }
                },
                {
                    "data": "Type",
                    "render": function (data) {
                        switch (parseInt(data)) {
                            case 10:
                                return "内線通話";
                            case 21:
                                return "外線発信";
                            case 22:
                                return "外線応答";
                            case 23:
                                return "外線着信";
                            default:
                                return "";
                        }
                    }
                },
                {"data": "Sender"},
                {"data": "Destination"},
            ]
        });
    });

    //-->
</script>
@endsection