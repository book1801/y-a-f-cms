<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/17
 * Time: 22:04
 */

class ManagerController extends \Yaf\Controller_Abstract{
    public $adtitle="后台管理";
    public function init(){
        session_start();
        if(isset($_SESSION['super_admin'])){
            if($_SESSION['super_admin']<>"aabbcc"){
                $this->redirect("/admin/login/index");
            }
        }else{
            $this->redirect("/admin/login/index");
        }
    }
}
?>