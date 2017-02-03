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

        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)->get();

        foreach ($dbGroups as $dbGroup) {
            $child = array();
            foreach ($dbGroup->childs as $dbChildGroup) {
                $grandson = array();
                foreach ($dbChildGroup->childs as $dbGrandsonGroup) {
                    $grandson[] = array(
                        'Id' => $dbGrandsonGroup->id,
                        'Name' => $dbGrandsonGroup->group_name,
                    );
                }
                $child[] = array(
                    'Id' => $dbChildGroup->id,
                    'Name' => $dbChildGroup->group_name,
                    'Child' => $grandson,
                );
            }

            $groups[$dbGroup->type][] = array(
                'Id' => $dbGroup->id,
                'Name' => $dbGroup->group_name,
                'Child' => $child,
            );
        }

        return view('addressbook.index', ['groups' => $groups]);
    }

}
