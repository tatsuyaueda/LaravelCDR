<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class AdminController extends Controller {

    public function getIndex() {

        $users = User::all()
                ->sortByDesc('id');

        return view('admin.index')
                        ->with('users', $users);
    }

    public function getAddUser() {

        return view('admin.AddUser');
    }

    public function postAddUser(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        \DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        \Session::flash('success_message', 'ユーザの追加が完了しました。');

        return redirect('admin/');
    }

    public function postDelUser(Request $request) {

        \DB::table('users')
                ->whereId($request->UserID)
                ->delete();

        \Session::flash('success_message', 'ユーザの削除が完了しました。');

        return redirect('admin/');
    }

}
