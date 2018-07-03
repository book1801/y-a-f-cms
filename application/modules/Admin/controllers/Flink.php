<?php
class FlinkController extends ManagerController{
    //列表页
    public function listAction(){
        $c=new flinkModel();
        $list=$c->getPartFlink(0);

        $this->getView()->assign("title","友情链接管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        return true;
    }

    //添加新转化记录
    public function addAction(){
        $request = $this->getRequest();
        if(null!=$request->getPost("word")){
            $word=$request->getPost("word");
            $link=$request->getPost("link");
            $indexorder=$request->getPost("indexorder");
            $status=$request->getPost("status");
            $pubdate=time();


            if($word<>"" && $link<>""){
                $bind=[
                    'word'=>$word,
                    'link'=>$link,
                    'status'=>$status,
                    'pubdate'=>$pubdate,
                    'indexorder'=>$indexorder
                ];
                $c=new flinkModel();
                $r=$c->addFlink($bind);
                if($r){
                    \Until\Fun::alert("添加成功！");
                    \Until\Fun::go("/admin/flink/list");
                }else{
                    \Until\Fun::alert("添加失败！");
                    \Until\Fun::go("/admin/flink/list");
                }
            }else{
                \Until\Fun::alert("添加失败！");
                \Until\Fun::go("/admin/flink/list");
            }
        }else{
            $this->getView()->assign("title","添加友情链接-".$this->adtitle);
        }

        return true;
    }

    //修改转化记录
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $c=new flinkModel();
        if(null!=$request->getPost("word")){
            $id=$request->getPost("id");
            $word=$request->getPost("word");
            $link=$request->getPost("link");
            $indexorder=$request->getPost("indexorder");
            $status=$request->getPost("status");


            if($word<>"" && $link<>""){
                $bind=[
                    'word'=>$word,
                    'link'=>$link,
                    'status'=>$status,
                    'indexorder'=>$indexorder
                ];

                #print_r($bind);die();

                $r=$c->editFlink($bind,"id=".$id);
                if($r){
                    $msg="修改友情链接成功！";
                }else{
                    $msg="修改友情链接失败！";
                }
            }else{
                $msg="修改友情链接失败！#tag1";
            }
        }

        $flink_p=$c->getPartFlink($id);
        $flink=$flink_p[0];

        $this->getView()->assign("title","修改新转化导向-".$this->adtitle);
        $this->getView()->assign("flink",$flink);
        $this->getView()->assign("msg",$msg);

        return true;
    }

    //删除转化记录
    public function delAction($id){
        $c=new flinkModel();
        $r=$c->delFlink($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/flink/list");
    }
}
?>