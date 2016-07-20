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

    public static function getUser($id){
        return User::find($id);
    }

}