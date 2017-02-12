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
        2 => '共通電話帳',
        9 => '個人電話帳',
    );

    /**
     * コンストラクタ
     */
    public function __construct() {

        // 全てのビューで利用する変数を定義
        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)->get();
        $Groups = $this->_buildGroups($dbGroups);

        \View::composer('addressbook.*', function($view) use ($Groups) {
            $view->with('AddressBookType', $this->AddressBookType);
            $view->with('Groups', $Groups);
        });
    }

    /**
     * トップページ
     * @return type
     */
    public function getIndex() {

        return view('addressbook.index');
    }

    /**
     * グループ管理
     * @return type
     */
    public function getGroup() {

        $dbGroups = \App\AddressBookGroup::all();

        $GroupList = array();

        foreach ($dbGroups as $group) {
            $GroupList[$group->type][] = $group;
        }

        return view('addressbook.group')
                        ->with('GroupList', $GroupList);
    }

    public function getGroupEdit($inputId = 0) {

        $id = intval($inputId);

        $AddressBook = $this->AddressBookType;
        // 権限が無い場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook')) {
            unset($AddressBook[1]);
            unset($AddressBook[2]);
        }

        $record = \App\AddressBookGroup::firstOrNew(['id' => $id]);

        // 権限が無く、既存レコード編集場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook') && isset($record->type) && $record->type != 9) {
            abort(403);
        }

        return view('addressbook.group_edit')
                        ->with('editAddressBookType', $AddressBook)
                        ->with('record', $record);
        
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

    public function getSel2Group(Request $req) {

        $type = intval($req['type']);
        $isDisable = $req['from'] == 'GroupEdit' ?  false : true;

        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)
                ->where('type', $type)
                ->get();

        return \Response::json($this->_buildGroups2($dbGroups, $isDisable)[1]);
    }

    /**
     * 
     * @param type $Groups
     * @param type $isDisable 末端のグループ以外を無効とするか
     * @param type $level
     * @return type
     */
    private function _buildGroups2($Groups, $isDisable, $level = 1) {

        $result = null;
        foreach ($Groups as $Group) {

            $result[$Group->type][] = array(
                'id' => $Group->id,
                'text' => $Group->group_name,
                'level' => $level,
                ($Group->childs->count() and $isDisable) ? 'disabled' : 'dummy' => 'false',
            );
            
            foreach ($Group->childs as $item) {
                $result[$Group->type][] = array(
                    'id' => $item->id,
                    'text' => $item->group_name,
                    'level' => $level + 1,
                    ($item->childs->count() and $isDisable) ? 'disabled' : 'dummy' => 'false',
                );

                if ($item->childs->count()) {
                    $result[$Group->type] = array_merge($result[$Group->type], $this->_buildGroups2($item->childs, $isDisable, $level + 2)[$Group->type]);
                }
            }
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
            abort(400);
        }

        $record = \App\AddressBook::find($id);

        return view('addressbook.detail', [
            'record' => $record
        ]);
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function getEdit($inputId = 0) {

        $id = intval($inputId);

        $AddressBook = $this->AddressBookType;
        // 権限が無い場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook')) {
            unset($AddressBook[1]);
            unset($AddressBook[2]);
        }

        $record = \App\AddressBook::firstOrNew(['id' => $id]);

        // 権限が無く、既存レコード編集場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook') && isset($record->type) && $record->type != 9) {
            abort(403);
        }

        return view('addressbook.edit')
                        ->with('editAddressBookType', $AddressBook)
                        ->with('record', $record);
    }

    /**
     * アドレス帳情報の編集
     * @param Request $req
     */
    public function postEdit(\App\Http\Requests\AddressBookRequest $req, $inputId = 0) {

        // 権限が無い場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook') && $req['type'] != 9) {
            abort(403);
        }

        $id = intval($inputId);
        $record = \App\AddressBook::firstOrNew(['id' => $id]);

        $record->position = $req['position'];
        $record->name_kana = $req['name_kana'];
        $record->name = $req['name'];
        $record->type = $req['type'];
        $record->groupid = $req['groupid'];
        $record->tel1 = $req['tel1'];
        $record->tel2 = $req['tel2'];
        $record->tel3 = $req['tel3'];
        $record->email = $req['email'];
        $record->comment = $req['comment'];

        $record->save();

        return redirect()->action('AddressBookController@getIndex');
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
        $typeId = intval($req['typeId']) ? intval($req['typeId']) : -1;

        $items = \App\AddressBook::select($column)
                ->where('type', $typeId);

        // 種別が個人の場合：ログイン中 ユーザの物のみを対象とする
        if ($typeId == 2) {
            $user = \Auth::user();
            $items = $items
                    ->where('owner_userid', $user['id']);
        }

        // 全体の件数を取得
        $allCount = $items->count();

        // グループで絞り込み
        if (intval($req['groupId'])) {
            $items = $items
                    ->where('groupid', $req['groupId']);
        }

        // キーワードで絞り込み
        if (strlen($req['keyword']) != 0) {
            $items = $items
                    ->where(function($query) use ($req) {
                $query
                ->orWhere('position', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('name', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('name_kana', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('tel1', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('tel2', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('tel3', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('email', 'like', '%' . $req['keyword'] . '%')
                ->orWhere('comment', 'like', '%' . $req['keyword'] . '%');
            });
        }

        $items = $items
                ->get();

        // 表示する件数だけ切り出す
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
