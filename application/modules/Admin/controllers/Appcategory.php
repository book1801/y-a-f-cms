<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/18
 * Time: 1:32
 */
class AppcategoryController extends ManagerController{
    //列表
    public function listAction(){
        $a=new appcategoryModel();
        $list=$a->getCategory(0);

        $this->getView()->assign("title","App分类管理-".$this->adtitle);
        $this->getView()->assign("list",$list);
        return true;
    }

    //添加
    public function addAction(){
        $request = $this->getRequest();
        $a=new appcategoryModel();
        if(null!=$request->getPost("category")){
            $category=$request->getPost("category");
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $description=$request->getPost("description");
            $indexorder=$request->getPost("indexorder");

            if(($category!=null) && ($title!=null)){
                $bind=[
                    "category"=>$category,
                    "title"=>$title,
                    "description"=>$description,
                    "indexorder"=>$indexorder,
                    "keyword"=>$keyword
                ];
                
                $r=$a->addCategory($bind);
                if($r){
                    \Until\Fun::alert("添加App分类成功！");
                    \Until\Fun::go("/admin/appcategory/list");
                }else{
                    \Until\Fun::alert("添加App分类失败！");
                    \Until\Fun::go("/admin/appcategory/add");
                }
            }else{
                \Until\Fun::alert("添加App分类失败！");
                \Until\Fun::go("/admin/appcategory/add");
            }

        }else{
            $this->getView()->assign("title","添加App分类-".$this->adtitle);

            return true;
        }

    }

    //修改
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $a=new appcategoryModel();
        
        if(($id==0) && (null!=$request->getPost("id"))){
            $id=$request->getPost("id");
            $category=$request->getPost("category");
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $description=$request->getPost("description");
            $indexorder=$request->getPost("indexorder");

            $bind=[
                "category"=>$category,
                "title"=>$title,
                "description"=>$description,
                "indexorder"=>$indexorder,
                "keyword"=>$keyword
            ];

            //print_r($bind);die();
            
            $r=$a->editCategory($bind,"id=".$id);
            if($r){
                $msg="修改成功！";
            }else{
                $msg="修改失败！";
            }
        }

        $appcategory=$a->getCategory($id);
        $appcategory=$appcategory[0];

        $this->getView()->assign("title","App分类管理-".$this->adtitle);
        $this->getView()->assign("category",$appcategory);
        $this->getView()->assign("msg",$msg);
        return true;
    }

    //删除
    public function delAction($id){
        $m=new appcategoryModel();
        $r=$m->delCategory($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/appcategory/list");
    }
}
?>