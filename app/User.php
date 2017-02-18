<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Notifications\CustomPasswordReset;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait; // add this trait to your user model
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * アドレス帳情報を取得
     * @return AddressBook
     */
    public function AddressBook()
    {

        // 内線電話帳で所有者が自分のIDは自分のアイテムとして処理する
        $item = \App\AddressBook::where('type', 1)
            ->where('owner_userid', $this->id)
            ->get()
            ->first();

        return $item;

    }

    /**
     * メールチャンネルに対する通知をルートする
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }

}
