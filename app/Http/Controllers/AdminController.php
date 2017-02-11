<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class AdminController extends Controller {

    public function getIndex() {

        $users = User::with(array('roles' => function($query) {
                        $query->orderBy('id', 'desc');
                    }))->get();

        return view('admin.index')
                        ->with('users', $users);
    }

    public function getAddUser() {

        $roles = \App\Role::all();

        return view('admin.AddUser')
                        ->with('roles', $roles);
    }

    public function postAddUser(Request $req) {

        $this->validate($req, [
            'name' => 'required',
            'username' => 'required|unique:users',
            'roles' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        $user = new \App\User;
        $user->name = $req['name'];
        $user->username = $req['username'];
        $user->name = $req['name'];
        $user->email = $req['email'];
        $user->password = bcrypt($req->password);
        $user->save();

        foreach ($req['roles'] as $role) {
            $user->roles()->attach($role);
        }

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
