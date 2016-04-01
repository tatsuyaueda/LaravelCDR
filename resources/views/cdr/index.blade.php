@extends('layout')

@section('content')
	<table class="table table-bordered table-condensed table-striped" id="view">
		<thead>
			<tr>
				<th>通話開始時間</th>
				<th>通話終了時間</th>
				<th>種別</th>
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
		$('#view').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Japanese.json"
			},
			"processing": false,
			"serverSide": true,
			"searching": false,
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
						switch (data) {
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