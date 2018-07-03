<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/17
 * Time: 1:39
 */
class LoginController extends \Yaf\Controller_Abstract{
    //登录首页
    public function indexAction(){
        session_start();
        if(isset($_SESSION['super_admin'])){
            if($_SESSION['super_admin']=="aabbcc"){
                $this->redirect("/admin/index/index");
            }
        }

        return true;
    }

    //登录验证
    public function loginAction(){
        $request = $this->getRequest();
        if(($request->getPost("username")=="your-user") && ($request->getPost("password")=="your-password")){
            session_start();
            $_SESSION['super_admin']="aabbcc";
            $this->redirect("/admin/index/index");
        }else{
            $this->redirect("/admin/login/index");
        }
    }

    //退出
    public function logoutAction(){
        session_start();
        unset($_SESSION);
        session_destroy();

        $this->redirect("/");
    }
}