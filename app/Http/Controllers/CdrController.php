<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 発着信履歴
 */
class CdrController extends Controller {

    //　通話種別
    var $type = array(
        10 => "内線通話",
        21 => "外線発信",
        22 => "外線応答",
        23 => "外線着信",
    );

    /**
     * トップページ
     * @return type
     */
    public function getIndex() {
        return view('cdr.index')
                        ->with('types', $this->type);
    }

    /**
     * 発着信履歴をJSONで返す
     * @param Request $req
     * @return type
     */
    public function postSearch(Request $req) {

        $draw = $req->input('draw');
        $start = $req->input('start');
        $length = $req->input('length');

        $allCount = \App\Cdr::all()->count();

        $column = ['StartDateTime', 'Duration', 'Type', 'Sender', 'Destination'];

        $items = \App\Cdr::select($column);

        if (strlen($req['Sender'])) {
            $items = $items
                    ->where('Sender', 'LIKE', '%' . $req['Sender'] . '%');
        }

        if (strlen($req['Destination'])) {
            $items = $items
                    ->where('Destination', 'LIKE', '%' . $req['Destination'] . '%');
        }

        if (strlen($req['StartDateTime']) && date_parse($req['StartDateTime']) && strlen($req['EndDateTime']) && date_parse($req['EndDateTime'])) {
            $items = $items
                    ->whereBetween('StartDateTime', array($req['StartDateTime'], $req['EndDateTime']));
        }

        $type = is_numeric($req['Type']) ? intval($req['Type']) : 0;
        
        if ($type !== 0) {
            $items = $items
                    ->where('Type', $req['Type']);
        }

        $items = $items
                ->get();

        // Sort
        if (is_array($req['order'][0])) {
            if ($req['order'][0]['dir'] == 'asc') {
                $items = $items
                        ->sortBy($column[$req['order'][0]['column']]);
            } else {
                $items = $items
                        ->sortByDesc($column[$req['order'][0]['column']]);
            }
        }

        $data = $items->slice($start, $length)->toArray();

        // Typeを文字列に変換
        foreach ($data as &$value) {
            $value['Type'] = $this->type[$value['Type']];
        }

        return \Response::json(
                        array(
                            'draw' => $draw,
                            'recordsTotal' => $allCount,
                            'recordsFiltered' => $items->count(),
                            'data' => array_values($data)
                        )
        );
    }

}
