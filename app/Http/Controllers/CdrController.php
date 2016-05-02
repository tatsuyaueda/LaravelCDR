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

        $column = ['StartDateTime', 'Duration', 'Type', 'Sender', 'Destination'];

        $items = \App\Cdr::select();

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

        return \Response::json(
                        array(
                            'draw' => $draw,
                            'recordsTotal' => $allCount,
                            'recordsFiltered' => $items->count(),
                            'data' => array_values($items->slice($start, $length)->toArray())
                        )
        );
    }

}
