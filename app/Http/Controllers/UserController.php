<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * ユーザ管理
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * ユーザ情報
     * @return $this
     */
    public function getIndex()
    {
        $record = \Auth::user();

        return view('user.index')
            ->with('record', $record);
    }

    /**
     * ユーザ情報 更新
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postIndex(Request $request)
    {

        // ToDo メールアドレスの変更時 確認する必要あり

        $UserID = \Auth::user()->id;

        if($UserID != $request->id){
            abort(403);
        }

        $User = \App\User::findOrFail($UserID);

        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$User->id,
            'email' => 'required|email|unique:users,email,'.$User->id,
        ]);

        $User->name = $request->name;
        $User->username = $request->username;
        $User->email = $request->email;

        $User->save();

        \Session::flash('success_message', '編集が完了しました。');

        return redirect('user/');

    }

    /**
     * 内線電話帳情報
     * @return $this
     */
    public function getAddressBook()
    {

        $UserID = \Auth::user()->id;

        $record = \App\AddressBook::where('type', 1)
            ->where('owner_userid', $UserID)
            ->get()
            ->first();

        if (!$record) {
            abort(403);
        }

        return view('user.addressbook')
            ->with('record', $record);

    }

    /**
     * パスワード変更
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPassword()
    {
        return view('user.password');
    }

    /**
     * パスワードの変更
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPassword(Request $request)
    {

        $UserID = \Auth::user()->id;

        $User = \App\User::findOrFail($UserID);

        $this->validate($request, [
            'old_password' => 'required|min:5',
            'new_password' => 'required|confirmed|min:5',
        ]);

        if (\Hash::check($request->old_password, $User->password)) {
            $User->fill([
                'password' => \Hash::make($request->new_password)
            ])->save();

            \Session::flash('success_message', 'パスワードの変更が完了しました。');
        } else {
            \Session::flash('error_message', '現在のパスワードが正しくありません。');
        }

        return redirect('user/password');
    }

}
