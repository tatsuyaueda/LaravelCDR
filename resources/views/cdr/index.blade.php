@extends('layout')

@section('content')
<div class="box-group" id="search">
    <div class="panel box box-default">
        <div class="box-header with-border">
            <h4 class="box-title">
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
                        <label for="searchSender" class="col-sm-1 control-label">発信者：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="searchSender">
                        </div>
                        <label for="searchDestination" class="col-sm-1 control-label">着信先：</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="searchDestination">
                        </div>
                        <div class="col-sm-offset-10">
                            <button class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                                検索
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="searchDateStart" class="col-sm-1 control-label">期間：</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="searchDaterangepicker" value="">
                        </div>
                        <div class="col-sm-offset-10">
                            <button class="btn btn-default" type="reset">
                                <span class="glyphicon glyphicon-remove"></span>
                                リセット
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="dataTables_wrapper dt-bootstrap">
            <table class="table table-bordered table-condensed table-striped dataTable" id="view">
                <thead>
                    <tr>
                        <th>通話日時</th>
                        <th>通話時間</th>
                        <th>種別</th>
                        <th>発信者</th>
                        <th>着信先</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
        $('#searchDaterangepicker').daterangepicker(
                {
                    ranges: {
                        '今日': [
                            moment().hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().hours(23).minutes(59).seconds(59).milliseconds(59)
                        ],
                        '昨日': [
                            moment().subtract(1, 'days').hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().subtract(1, 'days').hours(23).minutes(59).seconds(59).milliseconds(59)
                        ],
                        '過去7日間': [
                            moment().subtract(6, 'days').hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().hours(23).minutes(59).seconds(59).milliseconds(59)
                        ],
                        '過去30日間': [
                            moment().subtract(29, 'days').hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().hours(23).minutes(59).seconds(59).milliseconds(59)
                        ],
                        '今月': [
                            moment().startOf('month').hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().endOf('month').hours(23).minutes(59).seconds(59).milliseconds(59)
                        ],
                        '先月': [
                            moment().subtract(1, 'month').startOf('month').hours(0).minutes(0).seconds(0).milliseconds(0),
                            moment().subtract(1, 'month').endOf('month').hours(23).minutes(59).seconds(59).milliseconds(59)
                        ]
                    },
                    startDate: moment().startOf('month'),
                    endDate: moment().endOf('month'),
                    timePicker: true,
                    timePicker24Hour: true,
                    locale: {
                        format: "YYYY年M月D日 H時m分",
                        separator: " ～ ",
                        applyLabel: "OK",
                        customRangeLabel: "カスタム"
                    }
                }
        );

        // 検索条件のクリア
        $('#searchForm button:reset').click(function (event) {
            event.preventDefault();

            $('#searchSender').val('');
            $('#searchDestination').val('');

            $('#searchDaterangepicker').data('daterangepicker').setStartDate(moment().startOf('month'));
            $('#searchDaterangepicker').data('daterangepicker').setEndDate(moment().endOf('month'));

            $('#view').DataTable().draw();
        });

        // 検索
        $('#searchForm button:submit').click(function (event) {
            event.preventDefault();

            $('#view').DataTable().draw();
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
            "order": [[0, "desc"]],
            "processing": false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "{{action('CdrController@postSearch')}}",
                "type": "POST",
                "data": function (d) {
                    d.Sender = $('#searchSender').val();
                    d.Destination = $('#searchDestination').val();
                    d.StartDateTime = $('#searchDaterangepicker').data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
                    d.EndDateTime = $('#searchDaterangepicker').data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
                }
            },
            "columns": [
                {
                    "data": "StartDateTime",
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
                {"data": "Type"},
                {"data": "Sender"},
                {"data": "Destination"},
            ]
        });
    });

    //-->
</script>
@endsection