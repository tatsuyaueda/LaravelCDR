<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class CdrController extends Controller {

    public function getIndex() {
        return view('cdr.index');
    }

    public function postSearch(Request $req) {

        $draw = $req->input('draw');
        $start = $req->input('start');
        $length = $req->input('length');

        $allCount = \App\Cdr::all()->count();

        $column = ['StartDateTime', 'EndDateTime', 'Duration', 'Type', 'Sender', 'Destination'];

        $items = \App\Cdr::all();

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

        $items = $items
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

}
