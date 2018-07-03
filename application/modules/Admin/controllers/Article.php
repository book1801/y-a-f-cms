<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/18
 * Time: 1:32
 */
class ArticleController extends ManagerController{
    //列表
    public function listAction($page=1){
        $a=new articleModel();
        $limit=20;
        $page=$page > 1?$page:1;
        $start=($page -1) * $limit;
        $list=$a->getArticleInfoAllList(0,$start,$limit);


        $this->getView()->assign("title","文章管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        //翻页部分
        $pageplay=[];
        $count=$a->getArticleListCount(0);
        $maxpage=ceil($count / $limit);
        for($i=1;$i<=$maxpage;$i++){
            $pageplay[]=["page"=>$i,"link"=>"/admin/article/list/page/".$i];
        }
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);


        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("category_list",$category_list);
        return true;
    }

    //搜索
    public function searchAction(){
        $request = $this->getRequest();
        $categoryid=$request->getQuery("categoryid",0);
        $searchword=$request->getQuery("searchword","");
        $page=$request->getQuery("page",1);
        $page=$page > 1?$page:1;
        #print_r($status);

        $a=new articleModel();
        $limit=2;
        $start=($page -1) * $limit;

        #查询列表部分
        $list=$a->searchArticle($categoryid,$searchword);
        //print_r($list);die();

        $this->getView()->assign("title","文章管理-".$this->adtitle);
        $this->getView()->assign("list",$list);

        //翻页部分
        $pageplay=[];
        $count=$a->searchArticleCount($categoryid,$searchword);
        $maxpage=ceil($count / $limit);
        for($i=1;$i<=$maxpage;$i++){
            $pageplay[]=["page"=>$i,"link"=>"/admin/article/search?categoryid=".$categoryid."&searchword=".$searchword."&page=".$i];
        }
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);


        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("category_list",$category_list);
        $this->getView()->assign("categoryid",$categoryid);
        $this->getView()->assign("searchword",$searchword);
        return true;
    }

    //添加
    public function addAction(){
        $request = $this->getRequest();


        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("category_list",$category_list);


        $a=new articleModel();
        if(null!=$request->getPost("title")){
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $catid=$request->getPost("catid");
            $description=$request->getPost("description");
            $recommend=$request->getPost("recommend");
            $content=$request->getPost("content");
            $pubdate=time();
            $updated=time();
            $views=rand(5,15);


            if($title!=null){
                $bind=[
                    'title'=>$title,
                    "keyword"=>$title,
                    "catid"=>$catid,
                    "description"=>$description,
                    "recommend"=>$recommend,
                    "content"=>$content,
                    "pubdate"=>$pubdate,
                    "updated"=>$updated,
                    "views"=>$views,
                ];
                
                $r=$a->addArticle($bind);
                if($r){
                    \Until\Fun::alert("添加文章成功！");
                    \Until\Fun::go("/admin/article/list");
                }else{
                    \Until\Fun::alert("添加App失败！");
                    \Until\Fun::go("/admin/article/add");
                }
            }else{
                \Until\Fun::alert("添加App失败！");
                \Until\Fun::go("/admin/article/add");
            }

        }else{
            $this->getView()->assign("title","添加文章-".$this->adtitle);

            return true;
        }

    }

    //修改
    public function editAction($id=0){
        $msg="";
        $request = $this->getRequest();
        $a=new articleModel();
        if(null!=$request->getPost("id")){
            $id=$request->getPost("id");
            $title=$request->getPost("title");
            $keyword=$request->getPost("keyword");
            $catid=$request->getPost("catid");
            $description=$request->getPost("description");
            $recommend=$request->getPost("recommend");
            $content=$request->getPost("content");
            $updated=time();

            if($title!=null){
                $bind=[
                    'title'=>$title,
                    "keyword"=>$title,
                    "catid"=>$catid,
                    "description"=>$description,
                    "recommend"=>$recommend,
                    "content"=>$content,
                    "updated"=>$updated,
                ];


                $r=$a->editArticle($bind,"id=".$id);
                if($r){
                    $msg="修改文章成功！";
                }else{
                    $msg="修改文章失败！";
                }
            }else{
                $msg="修改文章失败！";
            }
        }
        //获取一个文章
        $article=$a->getArticle($id);


        //获取全部APP和文章混合分类
        $arp=new categoryModel();
        $category_list=$arp->getAllCategory();
        $this->getView()->assign("category_list",$category_list);
        $this->getView()->assign("article",$article);

        $this->getView()->assign("title","修改文章-".$this->adtitle);
        $this->getView()->assign("msg",$msg);
        return true;
    }

    //删除
    public function delAction($id){
        $m=new articleModel();
        $r=$m->delArticle($id);
        if($r){
            \Until\Fun::alert("删除成功");
        }else{
            \Until\Fun::alert("删除失败！");
        }
        \Until\Fun::go("/admin/article/list");
    }
}
?>