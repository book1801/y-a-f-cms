<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/18
 * Time: 1:32
 */
class PageController extends ManagerController{
    //列表
    public function listAction($page=1){
        $a=new pageModel();
        $limit=20;
        $page=$page > 1?$page:1;
        $start=($page -1) * $limit;
        $list=$a->getAllPage($start,$limit);


        $this->getView()->assign("title","Page管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        //翻页部分
        $pageplay=[];
        $count=$a->getPageCount();
        $maxpage=ceil($count / $limit);
        for($i=1;$i<=$maxpage;$i++){
            $pageplay[]=["page"=>$i,"link"=>"/admin/page/list/page/".$i];
        }
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);

        return true;
    }


    //添加
    public function addAction(){
        $request = $this->getRequest();



        $a=new pageModel();
        if(null!=$request->getPost("name")){
            $name=$request->getPost("name");
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $description=$request->getPost("description");
            $content=$request->getPost("content");
            $pubdate=time();
            $updated=time();

            if($name!=null){
                $bind=[
                    'name'=>$name,
                    'title'=>$title,
                    "keyword"=>$title,
                    "description"=>$description,
                    "content"=>$content,
                    "pubdate"=>$pubdate,
                    "updated"=>$updated,
                ];
                $r=$a->addPage($bind);
                if($r){
                    \Until\Fun::alert("添加PAGE成功！");
                    \Until\Fun::go("/admin/page/list");
                }else{
                    \Until\Fun::alert("添加PAGE失败！");
                    \Until\Fun::go("/admin/page/add");
                }
            }else{
                \Until\Fun::alert("添加PAGE失败！");
                \Until\Fun::go("/admin/page/add");
            }

        }else{
            $this->getView()->assign("title","添加PAGE-".$this->adtitle);

            return true;
        }

    }

    //修改
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $a=new pageModel();
        if(null!=$request->getPost("id")){
            $id=$request->getPost("id");
            $name=$request->getPost("name");
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $description=$request->getPost("description");
            $content=$request->getPost("content");
            $updated=time();

            if($name!=null){
                $bind=[
                    'name'=>$name,
                    'title'=>$title,
                    "keyword"=>$title,
                    "description"=>$description,
                    "content"=>$content,
                    "updated"=>$updated,
                ];


                $r=$a->editPage($bind,"id=".$id);
                if($r){
                    $msg="修改Page成功！";
                }else{
                    $msg="修改Page失败！";
                }
            }else{
                $msg="修改Page失败！";
            }
        }
        //获取一个Page
        $page=$a->getPageById($id);
        $this->getView()->assign("page",$page);

        $this->getView()->assign("title","修改Page-".$this->adtitle);
        $this->getView()->assign("msg",$msg);
        return true;
    }

    //删除
    public function delAction($id){
        $m=new pageModel();
        $r=$m->delPage($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/page/list");
    }
}
?>