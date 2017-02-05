<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * アドレス帳
 */
class AddressBookController extends Controller {

    // アドレス帳種別
    var $AddressBookType = array(
        1 => '内線電話帳',
        2 => "個人電話帳",
        3 => "共通電話帳",
    );

    /**
     * トップページ
     * @return type
     */
    public function getIndex() {

        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)->get();

        $ret = $this->_buildGroups($dbGroups);
        debug($ret);

        return view('addressbook.index', [
            'AddressBookType' => $this->AddressBookType,
            'groups' => $ret
        ]);
    }

    private function _buildGroups($Groups) {

        $result = null;

        foreach ($Groups as $Group) {
            $result_child = null;

            foreach ($Group->childs as $item) {
                $result_child[] = array(
                    'Id' => $item->id,
                    'Name' => $item->group_name,
                    'Child' => $item->childs->count() ? $this->_buildGroups($item->childs)[$Group->type] : null,
                );
            }

            $result[$Group->type][] = array(
                'Id' => $Group->id,
                'Name' => $Group->group_name,
                'Child' => $result_child,
            );
        }

        return $result;
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function getDetail($id) {

        if (!intval($id)) {
            // die
        }

        $record = \App\AddressBook::find($id);

        return view('addressbook.detail', [
            'AddressBookType' => $this->AddressBookType,
            'record' => $record
        ]);
    }

    /**
     *
     * @param Request $req
     * @return type
     */
    public function postSearch(Request $req) {

        $draw = $req->input('draw');
        $start = $req->input('start');
        $length = $req->input('length');

        $column = ['id', 'position', 'name', 'name_kana', 'tel1', 'tel2', 'tel3', 'email', 'comment'];

        $items = \App\AddressBook::select($column);

        $typeId = intval($req['typeId']) ? intval($req['typeId']) : -1;

        $items = $items
                ->where('type', $typeId);

        // 個人の場合自分の物のみを対象とする
        if ($typeId == 2) {
            $user = \Auth::user();
            $items = $items
                    ->where('owner_userid', $user['id']);
        }

        $allCount = $items->count();

        if (intval($req['groupId'])) {
            $items = $items
                    ->where('groupid', $req['groupId']);
        }

        $items = $items
                ->get();

        $data = $items->slice($start, $length)->toArray();

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
