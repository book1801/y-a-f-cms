<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 17:32
 */
class PageController extends BaseController{
    //某个单页的详情页
    public function showAction($name){
        $name=htmlspecialchars($name);
        $p=new pageModel();
        $pp=$p->getPage($name);
        if(count($pp) <1){
            Header("HTTP/1.1 404 Not Found");
            exit;
        }

        $page=$pp[0];
        $title=$page['title']."-".Yaf\Application::app()->getConfig()->web->name;
        $this->getView()->assign("title",$title);
        $this->getView()->assign("page",$page);

        //面包屑导航
        $mbnav=array(
            ["txt"=>"首页","link"=>Yaf\Application::app()->getConfig()->web->pcdomain,"rel"=>"nofollow"],
            ["txt"=>$page['title'],"link"=>"","rel"=>"nofollow"],
        );
        $this->getView()->assign("mbnav",$mbnav);
        
        //其他页面
        $page_list=$p->getPage($name,false);
        $this->getView()->assign("page_list",$page_list);
        
        return true;
    }
}