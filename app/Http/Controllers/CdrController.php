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

		$items = \App\Cdr::all()
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
