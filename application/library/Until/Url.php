<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 20:08
 */
namespace Until;

class Url{
    public static function createurl($controller,$action="index",$para=array()){
        $controller=strtolower($controller);
        $action=strtolower($action);

        //app控制器的url生成规则
        if($controller=="app"){
            $dir="app";
            if($action=="index"){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/";
            }elseif(($action=="content") && (isset($para["id"]))){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/".$para['id'].".html";
            }elseif(($action=="list") && (isset($para["appcategoryid"])) && (isset($para["categoryid"])) && (isset($para["page"]))){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/list-".$para["appcategoryid"]."-".$para['categoryid']."-".$para['page'].".html";
            }else{
                return "";
            }
        }

        //article控制器的url生成规则
        if($controller=="article"){
            $dir="article";
            if($action=="index"){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/";
            }elseif(($action=="content") && (isset($para["id"]))){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/".$para['id'].".html";
            }elseif(($action=="list") && (isset($para["categoryid"])) && (isset($para["page"]))){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/".$para['categoryid']."-".$para['page'].".html";
            }else{
                return "";
            }
        }

        //page控制器的url生成规则
        if($controller=="page"){
            $dir="page";
            if(isset($para["name"])){
                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/".$para["name"].".html";
            }else{
                return "";
            }
        }

        //question控制器的url生成规则
//        if($controller=="question"){
//            $dir="question";
//            if($action=="index"){
//                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/";
//            }elseif(($action=="content") && (isset($para["id"])) && (isset($para["page"]))){
//                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/".$para['id']."-".$para['page'].".html";
//            }elseif(($action=="list") && (isset($para["categoryid"])) && ($para["page"])){
//                return \Yaf\Application::app()->getConfig()->web->pcdomain.$dir."/list-".$para['id']."-".$para['page'].".html";
//            }else{
//                return "";
//            }
//        }

    }
}