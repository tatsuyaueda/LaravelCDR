<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $fillable = ['from_user_id', 'to_user_id', 'message'];
}
