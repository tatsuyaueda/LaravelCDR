<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class CdrController extends Controller {

    var $CallType = array(
        10 => '内線通話',
        21 => '外線発信',
        22 => '外線応答',
        23 => '外線着信',
    );

    public function getIndex() {
        return view('cdr.index');
    }

    public function postSearch(Request $req) {

        $draw = $req->input('draw');
        $start = $req->input('start');
        $length = $req->input('length');

        $allCount = \App\Cdr::all()->count();

        $items = \App\Cdr::all()
                ->sortByDesc('id')
                ->slice($start, $length)
                ->toArray();

        return \Response::json(
                        array(
                            'draw' => $draw,
                            'recordsTotal' => $allCount,
                            'recordsFiltered' => $allCount,
                            'data' => array_values($items)
                        )
        );
    }

    public function getExport() {

        $items = \App\Cdr::all()
                ->sortByDesc('id')
                ->toArray();

        $csvHeader = ['通話ID', '種別', '発信者', '着信先', '通話開始時間', '通話終了時間', '通話時間', '登録日時', '更新日時'];

        $stream = fopen('php://temp', 'r+b');
        fputcsv($stream, $csvHeader);

        foreach ($items as $item) {
            $item['Type'] = $this->CallType[$item['Type']];
            fputcsv($stream, $item);
        }

        rewind($stream);

        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="result.csv"',
        );

        return \Response::make($csv, 200, $headers);
    }

}
