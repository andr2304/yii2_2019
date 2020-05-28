<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 08.04.2020
 * Time: 9:30
 */

namespace common\helpers;

class DebugHelper
{
    public static function dd($param){
        echo '<pre>';
        var_dump($param);
        die;
    }
}