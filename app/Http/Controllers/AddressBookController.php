<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * アドレス帳
 */
class AddressBookController extends Controller
{

    // アドレス帳種別
    var $AddressBookType = array(
        1 => '内線電話帳',
        2 => '共通電話帳',
        9 => '個人電話帳',
    );

    /**
     * コンストラクタ
     */
    public function __construct()
    {

        // 全てのビューで利用する変数を定義
        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)->get();
        $Groups = $this->_buildGroups($dbGroups);

        \View::composer('addressbook.*', function ($view) use ($Groups) {
            $view->with('AddressBookType', $this->AddressBookType);
            $view->with('Groups', $Groups);
        });
    }

    /**
     * グループをツリー状にする
     * @param type $Groups
     * @return type
     */
    private function _buildGroups($Groups)
    {

        $result = null;

        // 親グループ
        foreach ($Groups as $Group) {
            $result_child = null;

            // 子グループ
            foreach ($Group->childs as $item) {
                // ToDo: 個人電話帳の考慮してない
                $ItemCount = \App\AddressBook::where('type', $item->type)
                    ->where('groupid', $item->id)
                    ->count();

                $result_child[] = array(
                    'Id' => $item->id,
                    'Name' => $item->group_name,
                    'ItemCount' => $ItemCount,
                    // 孫グループがある場合、再帰処理
                    'Child' => $item->childs->count() ? $this->_buildGroups($item->childs)[$Group->type] : null,
                );
            }

            // ToDo: 個人電話帳の考慮してない
            $ItemCount = \App\AddressBook::where('type', $Group->type)
                ->where('groupid', $Group->id)
                ->count();

            $result[$Group->type][] = array(
                'Id' => $Group->id,
                'Name' => $Group->group_name,
                'ItemCount' => $ItemCount,
                'Child' => $result_child,
            );
        }

        return $result;
    }

    /**
     * トップページ
     * @return type
     */
    public function getIndex()
    {

        return view('addressbook.index');
    }

    /**
     * 連絡先の削除
     * @param $inputId int
     * @return type
     */
    public function destroyIndex($inputId)
    {

        $id = intval($inputId);

        $address = \App\AddressBook::find($id);

        // 権限が無い場合は、個人電話帳のみとする
        // ToDo 所有者チェック
        if (!\Entrust::can('edit-addressbook') && $address['type'] != 9) {
            abort(403);
        }

        $address->delete();
        \Session::flash('success_message', '連絡先の削除が完了しました。');

        return redirect()->action('AddressBookController@getIndex');

    }

    /**
     * グループ管理
     * @return type
     */
    public function getGroup()
    {

        return view('addressbook.group');
    }

    /**
     * グループ編集
     * @param type $inputId
     * @return type
     */
    public function getGroupEdit($inputId = 0)
    {

        $id = intval($inputId);

        $AddressBook = $this->AddressBookType;
        // 権限が無い場合は、個人電話帳のみとする
        if (!\Entrust::can('edit-addressbook')) {
            unset($AddressBook[1]);
            unset($AddressBook[2]);
        }

        $record = \App\AddressBookGroup::firstOrNew(['id' => $id]);

        // 権限が無く、既存レコード編集場合は、個人電話帳のみとする
        // ToDo 自分が所有している電話帳かのチェック必要
        if (!\Entrust::can('edit-addressbook') && isset($record->type) && $record->type != 9) {
            abort(403);
        }

        return view('addressbook.group_edit')
            ->with('editAddressBookType', $AddressBook)
            ->with('record', $record);
    }

    /**
     * グループ編集
     * @param Request $req
     */
    public function postGroupEdit(\App\Http\Requests\AddressBookGroupRequest $req, $inputId = 0)
    {

        // 権限が無い場合は、個人電話帳のみとする
        // ToDo 自分が所有しているグループかのチェック必要
        if (!\Entrust::can('edit-addressbook') && $req['type'] != 9) {
            abort(403);
        }

        $id = intval($inputId);
        $record = \App\AddressBookGroup::firstOrNew(['id' => $id]);

        $record->parent_groupid = $req['parent_groupid'];
        $record->type = $req['type'];
        $record->group_name = $req['group_name'];

        $record->save();

        \Session::flash('success_message', '追加・編集が完了しました。');

        return redirect()->action('AddressBookController@getGroup');
    }

    /**
     * アドレス帳グループ 削除
     * @param type $inputId
     * @return type
     */
    public function destroyGroup($inputId)
    {

        $id = intval($inputId);

        $group = \App\AddressBookGroup::find($id);

        $ItemCount = \App\AddressBook::where('type', $group->type)
            ->where('groupid', $group->id)
            ->count();

        // 権限が無い場合は、個人電話帳のみとする
        // ToDo 所有者チェック
        if (!\Entrust::can('edit-addressbook') && $group['type'] != 9) {
            abort(403);
        }

        if ($ItemCount == 0 && $group->childs == null) {
            $group->delete();
            \Session::flash('success_message', 'グループの削除が完了しました。');
        } else {
            \Session::flash('error_message', '該当グループに所属する電話帳があるか、子グループが存在するため、削除出来ません。');
        }

        return redirect()->action('AddressBookController@getGroup');
    }

    /**
     * select2向け グループ一覧
     * @param Request $req
     * @return type
     */
    public function getSel2Group(Request $req)
    {

        $type = intval($req['type']);

        $isDisable = $req['from'] == 'GroupEdit' ? false : true;

        $dbGroups = \App\AddressBookGroup::where('parent_groupid', 0)
            ->where('type', $type)
            ->get();

        if ($dbGroups->count() == 0) {
            $result = array();
        } else {
            $result = $this->_buildGroups2($dbGroups, $isDisable);
        }

        if ($req['from'] == 'GroupEdit') {
            array_unshift($result, array(
                'id' => '0',
                'text' => '親グループ',
                'level' => 1,
            ));
        }

        return \Response::json($result);
    }

    /**
     *
     * @param type $Groups
     * @param type $isDisable 末端のグループ以外を無効とするか
     * @param type $level
     * @return type
     */
    private function _buildGroups2($Groups, $isDisable, $level = 1)
    {

        $result = null;
        foreach ($Groups as $Group) {

            $result[] = array(
                'id' => $Group->id,
                'text' => $Group->group_name,
                'level' => $level,
                ($Group->childs->count() and $isDisable) ? 'disabled' : 'dummy' => 'false',
            );

            foreach ($Group->childs as $item) {
                $result[] = array(
                    'id' => $item->id,
                    'text' => $item->group_name,
                    'level' => $level + 1,
                    ($item->childs->count() and $isDisable) ? 'disabled' : 'dummy' => 'false',
                );

                if ($item->childs->count()) {
                    $result = array_merge($result, $this->_buildGroups2($item->childs, $isDisable, $level + 2));
                }
            }
        }

        return $result;
    }

    /**
     * 詳細
     * @param type $id
     * @return type
     */
    public function getDetail($id)
    {

        if (!intval($id)) {
            abort(400);
        }

        $record = \App\AddressBook::find($id);

        // 個人電話帳を参照する場合、ログイン中 ユーザと所有者が違う場合は 403 とする
        if ($record->type == 9 && $record->owner_userid != \Auth::user()->id) {
            abort(403);
        }

        return view('addressbook.detail', [
            'record' => $record
        ]);
    }

    /**
     * アドレス帳 編集
     * @param type $id
     * @return type
     */
    public function getEdit($inputId = 0)
    {

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
     * アドレス帳 編集
     * @param Request $req
     */
    public function postEdit(\App\Http\Requests\AddressBookRequest $req, $inputId = 0)
    {

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

        \Session::flash('success_message', '追加・編集が完了しました。');

        return redirect()->action('AddressBookController@getIndex');
    }

    /**
     *
     * @param Request $req
     * @return type
     */
    public function postSearch(Request $req)
    {

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
                ->where(function ($query) use ($req) {
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
