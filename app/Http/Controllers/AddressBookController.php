<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * アドレス帳
 */
class AddressBookController extends Controller {

    /**
     * トップページ
     * @return type
     */
    public function getIndex() {
        return view('addressbook.index');
    }

}
