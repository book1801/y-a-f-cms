<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 21:13
 * Use:前端所有控制器的基类
 */
class BaseController extends \Yaf\Controller_Abstract{
    public function init(){
        //获取菜单
        $d=new menuModel();
        $menu=$d->getMenu();
        $this->getView()->assign("menu",$menu);
    }
}