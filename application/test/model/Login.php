<?php

namespace app\test\model;

use think\Model;

class Login extends Model
{
    protected $table="user";

    static public function login($username,$pass){
        return self::where('username',$username)
            ->where('pass',$pass)
            ->find();
    }
}
