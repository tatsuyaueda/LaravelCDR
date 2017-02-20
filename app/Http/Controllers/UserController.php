<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{

    public function getIndex()
    {
        $UserID = \Auth::user()->id;

        return view('user.index');
    }

    public function getAddressBook()
    {

        $UserID = \Auth::user()->id;

        $record = \App\AddressBook::where('type', 1)
            ->where('owner_userid', $UserID)
            ->get()
            ->first();

        if(!$record){
            abort(403);
        }

        return view('user.addressbook')
            ->with('record', $record);

    }

    public function getPassword()
    {
        return view('user.password');
    }

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
