<?php
class ConversionController extends ManagerController{
    //列表页
    public function listAction(){
        $c=new conversionModel();
        $list=$c->getPartConversion(0);

        $this->getView()->assign("title","转化导向管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        return true;
    }

    //添加新转化记录
    public function addAction(){
        $request = $this->getRequest();
        if(null!=$request->getPost("controller")){
            $controller=$request->getPost("controller");
            $action=$request->getPost("action");
            $paraid=$request->getPost("paraid");
            $title=$request->getPost("title");
            $link=$request->getPost("link");
            $pubdate=time();
            $updated=time();
            $indexorder=$request->getPost("indexorder");

            if($controller<>"" && $action<>""){
                $bind=[
                    'controller'=>$controller,
                    'action'=>$action,
                    'paraid'=>$paraid,
                    'title'=>$title,
                    'link'=>$link,
                    'pubdate'=>$pubdate,
                    'updated'=>$updated,
                    'indexorder'=>$indexorder
                ];
                $c=new conversionModel();
                $r=$c->addConversion($bind);
                if($r){
                    \Until\Fun::alert("添加成功！");
                    \Until\Fun::go("/admin/conversion/list");
                }else{
                    \Until\Fun::alert("添加失败！");
                    \Until\Fun::go("/admin/conversion/list");
                }
            }else{
                \Until\Fun::alert("添加失败！控制器和操作器不能为空！");
                \Until\Fun::go("/admin/conversion/list");
            }
        }else{
            $this->getView()->assign("title","添加新转化导向-".$this->adtitle);
        }

        return true;
    }

    //修改转化记录
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $c=new conversionModel();
        if(null!=$request->getPost("controller")){
            $id=$request->getPost("id");
            $controller=$request->getPost("controller");
            $action=$request->getPost("action");
            $paraid=$request->getPost("paraid");
            $title=$request->getPost("title");
            $link=$request->getPost("link");
            $pubdate=time();
            $updated=time();
            $indexorder=$request->getPost("indexorder");

            if($controller<>"" && $action<>""){
                $bind=[
                    'controller'=>$controller,
                    'action'=>$action,
                    'paraid'=>$paraid,
                    'title'=>$title,
                    'link'=>$link,
                    'pubdate'=>$pubdate,
                    'updated'=>$updated,
                    'indexorder'=>$indexorder
                ];

                $r=$c->editConversion($bind,"id=".$id);
                if($r){
                    $msg="修改转化导向成功！";
                }else{
                    $msg="修改转化导向失败！";
                }
            }else{
                $msg="控制器和操作器不能为空！";
            }
        }

        $conversion_p=$c->getPartConversion($id);
        $conversion=$conversion_p[0];

        $this->getView()->assign("title","修改新转化导向-".$this->adtitle);
        $this->getView()->assign("conversion",$conversion);
        $this->getView()->assign("msg",$msg);

        return true;
    }

    //删除转化记录
    public function delAction($id){
        $c=new conversionModel();
        $r=$c->delConversion($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/conversion/list");
    }
}
?>