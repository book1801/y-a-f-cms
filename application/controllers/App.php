<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 17:34
 */
class AppController extends BaseController{
    //app软件首页
    public function indexAction(){
        $title="手机赚钱软件_手机赚钱软件排行榜-".Yaf\Application::app()->getConfig()->web->name;
        $this->getView()->assign("title",$title);
		$this->getView()->assign("keyword","手机赚钱软件,手机赚钱软件排行榜");
        $this->getView()->assign("description","最热门的手机赚钱排行榜，各类手机赚钱软件，主要有：手游赚钱、问答赚钱、阅读赚钱；支持各类手机：安卓、苹果、平板、电脑等。另外还有日赚项目在等你哦。");

        //获取APP分类
        $ac=new appcategoryModel();
        $appcategory_list=$ac->getCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);

        //获取文章和APP的混合分类
        $c=new categoryModel();
        $category_list=$c->getAllCategory();
        $this->getView()->assign("category_list",$category_list);

        //获取app列表
        $a=new appModel();
        $applist=$a->getAppInfoList('1','0','0','views','desc',0,10);
        $this->getView()->assign("applist",$applist);

        //获取用户转化路径
        $conv=new conversionModel();
        $top_list=$conv->getConversion("app","index");
        $this->getView()->assign("top_list",$top_list);

        //最近更新的app
        $app_new_list=$a->getAppList("status=1","updated","desc",0,10);
        $this->getView()->assign("app_new_list",$app_new_list);

        return true;
    }

    //app软件分类列表页
    /*
     * appcategoryid:对应appcategory表中的id
     * categoryid:对应categoryid对应articlecategory表中的id
     * */
    public function listAction($appcategoryid,$categoryid,$page){
        $appcategoryid=intval($appcategoryid);
        $categoryid=intval($categoryid);
        $page=intval($page);

        $appc=new appcategoryModel();
        $artc=new categoryModel();

        $title="";
        if($appcategoryid){
            $appcategory=$appc->getCategory($appcategoryid);
            $title=$appcategory[0]["category"].$title;
        }else{
            $title="手机";
        }

        if($categoryid){
            $articlecategory=$artc->getCategory($categoryid);
            $title=$title.$articlecategory["category"];
        }else{
            $title=$title."赚钱";
        }
        $pagetitle=$title."软件排行榜";
        if($page > 1){
            $title=$pagetitle."_第".$page."页-".\Yaf\Application::app()->getConfig()->web->name;
        }else{
            $title=$pagetitle."-".\Yaf\Application::app()->getConfig()->web->name;
        }

        $this->getView()->assign("title",$title);
        $this->getView()->assign("pagetitle",$pagetitle);

        //获取所有手机软件分类
        $appcategory_list=$appc->getCategory(0);
        $appcategory_list[]=["category"=>"全部","id"=>0];
        $this->getView()->assign("appcategory_list",$appcategory_list);

        //获取所有手机和文章混合分类
        $category_list=$artc->getAllCategory();
        $category_list[]=["category"=>"全部","id"=>0];
        $this->getView()->assign("category_list",$category_list);

        //获取app列表和翻页
        $limit=10;
        $start=$page > 0?($page-1) * $limit:0;
        $a=new appModel();
        #获取app列表
        $applist=$a->getAppInfoList('1',$appcategoryid,$categoryid,'views','desc',$start,$limit);
        #获取翻页
        $pageplay=[];
        $pagecount=ceil($a->getAppCount()/$limit);
        for($i=1;$i<=$pagecount;$i++){
            $pageplay[]=["page"=>$i,"link"=>\Until\Url::createurl("app","list",["appcategoryid"=>$appcategoryid,"categoryid"=>$categoryid,"page"=>$i])];
        }
        $this->getView()->assign("applist",$applist);
        $this->getView()->assign("page",$page);
        $this->getView()->assign("appcategoryid",$appcategoryid);
        $this->getView()->assign("categoryid",$categoryid);
        $this->getView()->assign("pageplay",$pageplay);

        //获取用户转化路径
        $conv=new conversionModel();
        if($appcategoryid > 0 || $categoryid >0){
            $top_list1=array();
            $top_list2=array();
            if($appcategoryid > 0){
                $top_list1=$conv->getConversion("app","list",$appcategoryid);
                $app_new_list=$a->getAppList("status=1 and appcategoryid='".$appcategoryid."'","updated","desc",0,8);
                $this->getView()->assign("app_new_list",$app_new_list);#最近更新的app
            }
            if($categoryid > 0){
                $top_list2=$conv->getConversion("article","list",$categoryid);
                $app_new_list=$a->getAppList("status=1 and categoryid='".$categoryid."'","updated","desc",0,8);
                $this->getView()->assign("app_new_list",$app_new_list);#最近更新的app
            }
            $top_list=array_merge($top_list1,$top_list2);
        }else{
            $top_list=$conv->getConversion("app","index");
            $app_new_list=$a->getAppList("status=1","updated","desc",0,8);
            $this->getView()->assign("app_new_list",$app_new_list);#最近更新的app
        }
        $this->getView()->assign("top_list",$top_list);



        return true;

    }

    //app软件详情页
    public function contentAction($id){
        $id=intval($id);

        //获取指定ID的app
        $a=new appModel();
        $a_row=$a->getApp($id,True);
        $ap=$a_row[0];
        $title=$ap["title"]."-".\Yaf\Application::app()->getConfig()->web->name;
        $this->getView()->assign("title",$title);
        $this->getView()->assign("ap",$ap);

        //获取所有APP分类和混合分类
        $appc=new appcategoryModel();
        $appcategory_list=$appc->getCategory();
        $artc=new categoryModel();
        $category_list=$artc->getAllCategory();
        $this->getView()->assign("appcategory_list",$appcategory_list);
        $this->getView()->assign("category_list",$category_list);
        
        //获取右侧App，内链优化
        $app_new_list=$a->getAppBar($id,8);
        $this->getView()->assign("app_new_list",$app_new_list);

        //面包屑导航
        $mbnav=array(
            ["txt"=>"首页","link"=>Yaf\Application::app()->getConfig()->web->pcdomain,"rel"=>"nofollow"],
            ["txt"=>"赚钱软件","link"=>\Until\Url::createurl("app","index"),"rel"=>"nofollow"],
            ["txt"=>$ap['title'],"link"=>"","rel"=>"nofollow"],
        );
        $this->getView()->assign("mbnav",$mbnav);

        //用户转化路径
        $pagetitle="赚钱软件";
        if($ap["appcategoryid"] > 0){
            $pagetitle=$ap["appcategory"];
        }else{
            $pagetitle="手机";
        }
        if($ap["categoryid"]>0){
            $pagetitle=$pagetitle.$ap["articlecategory"];
        }else{
            $pagetitle=$pagetitle."赚钱";
        }
        $this->getView()->assign("pagetitle",$pagetitle);
        $c=new conversionModel();
        $top_list=$c->getConversion("app","list",$ap["appcategoryid"]);
        $top_list=array_merge($top_list,$c->getConversion("article","list",$ap["categoryid"]));
        $this->getView()->assign("top_list",$top_list);
        
//        //获取评论
//        $comm=new commentModel();
//        $comment_list=$comm->getAppComment($id,1,10);
//        $this->getView()->assign("comment_list",$comment_list);
//
//        //获取评论翻页
//        $commentcount=$comm->getAppCommentCount($id);
//        $maxpage=ceil($commentcount/ 10);
//        $pageplay=[];
//        for($i=1;$i<=$maxpage;$i++){
//            $pageplay[]=["page"=>$i,"link"=>\Until\Url::createurl("comment","list",["type"=>"APP","typeid"=>$id,"page"=>$i])];
//        }
//        $this->getView()->assign("pageplay",$pageplay);


        return true;
    }
}