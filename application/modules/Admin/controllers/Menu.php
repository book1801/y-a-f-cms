<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/17
 * Time: 19:59
 */

class MenuController extends ManagerController{
    //列表
    public function listAction($page=1){
        $m=new menuModel();
        $list=$m->getMenu();

        $this->getView()->assign("title","菜单管理-".$this->adtitle);
        $this->getView()->assign("list",$list);
        
        return true;
    }

    //添加菜单
    public function addAction(){
        $request = $this->getRequest();

        if(null!==($request->getPost("text"))){
            $text=$request->getPost("text");
            $link=$request->getPost("link");
            $indexorder=$request->getPost("indexorder");
            $alt=$request->getPost("alt");

            $bind=["text"=>$text,"link"=>$link,"indexorder"=>$indexorder,"alt"=>$alt];
            $m=new menuModel();
            $r=$m->addMenu($bind);
            if($r){
                \Until\Fun::alert("添加成功！");
                \Until\Fun::go("/admin/menu/list");
                #$this->redirect("/admin/menu/list");
            }
        }else{
            $this->getView()->assign("title","添加菜单-".$this->adtitle);
        }

        return true;
    }
    
    //编辑菜单页
    public function editAction($id=0){
        $m=new menuModel();
        $this->getView()->assign("title","编辑菜单-".$this->adtitle);
        $request = $this->getRequest();
        $msg="";
        if(($id==0) && (null!==($request->getPost("text")))){
            $id=$request->getPost("id");
            $text=$request->getPost("text");
            $link=$request->getPost("link");
            $indexorder=$request->getPost("indexorder");
            $alt=$request->getPost("alt");

            if(empty($text) || empty($link)){
                $msg="修改失败！菜单名称或链接不能为空！";
            }else{
                $bind=["text"=>$text,"link"=>$link,"indexorder"=>$indexorder,"alt"=>$alt];
                $r=$m->updateMenu($bind,"id=".$id);
                if($r){
                    $msg="修改成功！";
                }else{
                    $msg="修改失败！";
                }
            }
        }

        $menu=$m->getOneMenu($id);
        $this->getView()->assign("menu",$menu);


        $this->getView()->assign("msg",$msg);

        return true;
    }

    //删除菜单
    public function delAction($id){
        $m=new menuModel();
        $r=$m->delMenu($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/menu/list");
        #$this->redirect("/admin/menu/list");
    }
}