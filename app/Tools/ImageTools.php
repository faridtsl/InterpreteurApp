<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 7/24/16
 * Time: 1:07 PM
 */

namespace App\Tools;


use Illuminate\Support\Facades\Storage;

class ImageTools{

    public static function getName($file,$request){
        return $request['nom'].'_'.$request['prenom'].rand(11111,99999).'.'.$file->getClientOriginalExtension();
    }

    public static function getImage($img){
        return Storage::disk('img')->get($img);
    }


}