<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/18
 * Time: 1:32
 */
require_once  APPLICATION_PATH."/application/modules/Admin/library/bulletproof.php";

class AppController extends ManagerController{
    //列表
    public function listAction($page=1){
        $a=new appModel();
        $limit=20;
        $page=$page > 1?$page:1;
        $start=($page -1) * $limit;
        $list=$a->getAppInfoList(false,0,0,'pubdate','desc',$start,$limit);

        $this->getView()->assign("title","App管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        //翻页部分
        $pageplay=[];
        $count=$a->getAppCount(false);
        $maxpage=ceil($count / $limit);
        for($i=1;$i<=$maxpage;$i++){
            $pageplay[]=["page"=>$i,"link"=>"/admin/app/list/page/".$i];
        }
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);

        //获取全部APP分类，搜索用
        $ap=new appcategoryModel();
        $appcategory_list=$ap->getCategory(0);

        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);
        $this->getView()->assign("category_list",$category_list);
        return true;
    }

    //搜索
    public function searchAction(){
        $request = $this->getRequest();
        $appcategoryid=$request->getQuery("appcategoryid",0);
        $categoryid=$request->getQuery("categoryid",0);
        $status=$request->getQuery("status",2);
        $page=$request->getQuery("page",1);
        $page=$page > 1?$page:1;
        #print_r($status);

        $a=new appModel();
        $limit=20;
        $start=($page -1) * $limit;

        #查询列表部分
        $q_status="1";
        if($status==2){
            $q_status=false;
        }elseif($status==0){
            $q_status="status=0";
        }else{
            $q_status="status=1";
        }
        $list=$a->getAppInfoList($q_status,$appcategoryid,$categoryid,'pubdate','desc',$start,$limit);



        $this->getView()->assign("title","App管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        //翻页部分
        $pageplay=[];
        $count=$a->getAppFilterCount($status,$appcategoryid,$categoryid);
        $maxpage=ceil($count / $limit);
        for($i=1;$i<=$maxpage;$i++){
            $pageplay[]=["page"=>$i,"link"=>"/admin/app/search?appcategoryid=".$appcategoryid."&categoryid=".$categoryid."&status=".$status."&page=".$i];
        }
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);

        //获取全部APP分类，搜索用
        $ap=new appcategoryModel();
        $appcategory_list=$ap->getCategory(0);

        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);
        $this->getView()->assign("category_list",$category_list);
        $this->getView()->assign("status",$status);
        $this->getView()->assign("categoryid",$categoryid);
        $this->getView()->assign("appcategoryid",$appcategoryid);
        return true;
    }

    //添加
    public function addAction(){
        $request = $this->getRequest();

        //获取全部APP分类
        $ap=new appcategoryModel();
        $appcategory_list=$ap->getCategory(0);

        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);
        $this->getView()->assign("category_list",$category_list);


        $a=new appModel();
        if(null!=$request->getPost("appname")){
            $appname=$request->getPost("appname");
            $title=$request->getPost("title");
            $system=$request->getPost("system");
            $categoryid=$request->getPost("categoryid");
            $appcategoryid=$request->getPost("appcategoryid");
            $version=$request->getPost("version");
            $size=$request->getPost("size");
            $pcdownlink=$request->getPost("pcdownlink");
            $pgdownlink=$request->getPost("pgdownlink");
            $azdownlink=$request->getPost("azdownlink");
            $recommend=$request->getPost("recommend");
            $status=$request->getPost("status");
            $content=$request->getPost("content");
            $pubdate=time();
            $updated=time();
            $views=rand(5,15);
            $downs=0;
            $pcdowns=0;
            $mdowns=0;


            //上传图片部分
            $thumb="";
            $image = new Bulletproof\Image($_FILES);
            $image->setDimension(71, 71);
            $image->setMime(array('jpeg','png','gif'));
            $image->setLocation("upload/thumb", 0666);
            if($image["thumb"]){
                $upload = $image->upload();

                if($upload){
                    $thumb= "/".$upload->getFullPath(); // uploads/cat.gif
                }else{
                    \Until\Fun::alert("添加App失败！".$image["error"]);
                    \Until\Fun::go("/admin/app/add");
                    die();
                }
            }
            //print_r($image);die();


            if(($appname!=null) && ($title!=null)){
                $bind=[
                    'appname'=>$appname,
                    "system"=>$system,
                    "categoryid"=>$categoryid,
                    "title"=>$title,
                    "appcategoryid"=>$appcategoryid,
                    "version"=>$version,
                    "size"=>$size,
                    "pcdownlink"=>$pcdownlink,
                    "azdownlink"=>$azdownlink,
                    "pgdownlink"=>$pgdownlink,
                    "recommend"=>$recommend,
                    "status"=>$status,
                    "content"=>$content,
                    "pubdate"=>$pubdate,
                    "updated"=>$updated,
                    "views"=>$views,
                    "downs"=>$downs,
                    "pcdowns"=>$pcdowns,
                    "mdowns"=>$mdowns,
                    "thumb"=>$thumb
                ];
                
                $r=$a->addApp($bind);
                if($r){
                    \Until\Fun::alert("添加App成功！");
                    \Until\Fun::go("/admin/app/list");
                }else{
                    \Until\Fun::alert("添加App失败！");
                    \Until\Fun::go("/admin/app/add");
                }
            }else{
                \Until\Fun::alert("添加App失败！");
                \Until\Fun::go("/admin/app/add");
            }

        }else{
            $this->getView()->assign("title","添加App-".$this->adtitle);

            return true;
        }

    }

    //修改
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $a=new appModel();
        if(null!=$request->getPost("appname")){
            $id=$request->getPost("id");
            $appname=$request->getPost("appname");
            $title=$request->getPost("title");
            $system=$request->getPost("system");
            $categoryid=$request->getPost("categoryid");
            $appcategoryid=$request->getPost("appcategoryid");
            $version=$request->getPost("version");
            $size=$request->getPost("size");
            $pcdownlink=$request->getPost("pcdownlink");
            $pgdownlink=$request->getPost("pgdownlink");
            $azdownlink=$request->getPost("azdownlink");
            $recommend=$request->getPost("recommend");
            $status=$request->getPost("status");
            $content=$request->getPost("content");
            $updated=time();
            $views=rand(5,15);
            $downs=0;
            $pcdowns=0;
            $mdowns=0;

            if(($appname!=null) && ($title!=null)){
                $bind=[
                    'appname'=>$appname,
                    "system"=>$system,
                    "categoryid"=>$categoryid,
                    "title"=>$title,
                    "appcategoryid"=>$appcategoryid,
                    "version"=>$version,
                    "size"=>$size,
                    "pcdownlink"=>$pcdownlink,
                    "azdownlink"=>$azdownlink,
                    "pgdownlink"=>$pgdownlink,
                    "recommend"=>$recommend,
                    "status"=>$status,
                    "content"=>$content,
                    "updated"=>$updated,
                    "views"=>$views,
                    "downs"=>$downs,
                    "pcdowns"=>$pcdowns,
                    "mdowns"=>$mdowns,
                ];
                if($_FILES["thumb"]["name"]<>""){
                    //上传图片部分
                    $image = new Bulletproof\Image($_FILES);
                    $image->setDimension(71, 71);
                    $image->setMime(array('jpeg','png','gif'));
                    $image->setLocation("upload/thumb", 0666);
                    if($image["thumb"]){
                        $upload = $image->upload();

                        if($upload){
                            $newthumb= "/".$upload->getFullPath(); // uploads/cat.gif
                        }else{
                            \Until\Fun::alert("修改App失败！".$image["error"]);
                            \Until\Fun::go("/admin/app/edit/id/".$id);
                            die();
                        }
                    }
                    $bind["thumb"]=$newthumb;
                }

                $r=$a->editApp($bind,"id=".$id);
                if($r){
                    $msg="修改App成功！";
                }else{
                    $msg="修改App失败！";
                }
            }else{
                $msg="修改App失败！";
            }
        }
        //获取一个APP
        $app_l=$a->getApp($id);
        $app=$app_l[0];

        //获取全部APP分类，搜索用
        $ap=new appcategoryModel();
        $appcategory_list=$ap->getCategory(0);

        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);
        $this->getView()->assign("category_list",$category_list);
        $this->getView()->assign("app",$app);

        $this->getView()->assign("title","修改App-".$this->adtitle);
        $this->getView()->assign("msg",$msg);
        return true;
    }

    //删除
    public function delAction($id){
        $m=new appModel();
        $r=$m->delApp($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/app/list");
    }
}
?>