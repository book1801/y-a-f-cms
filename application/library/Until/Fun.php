<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 17:47
 */
namespace Until;

class Fun{
    public static function alert($msg){
        echo "<script>alert('".$msg."');</script>";
    }

    public static function go($url){
        echo "<script>window.location.href='".$url."';</script>";
    }
}