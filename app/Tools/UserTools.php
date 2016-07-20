<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/19/16
 * Time: 1:37 PM
 */

namespace App\Tools;


use App\User;

class UserTools{

    public function addUser($r){
        $u = new User();
        $u->name = $r['name'];
        $u->email = $r['email'];
        $u->password = bcrypt($r['password']);
        $u->isAdmin = false;
        $u->save();
        return $u;
    }

}