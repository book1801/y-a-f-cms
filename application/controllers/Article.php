<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 17:29
 */
class ArticleController extends BaseController{
    //文章首页
    public function indexAction(){

        $this->getView()->assign("title","手机赚钱方法_手机怎么赚钱-".Yaf\Application::app()->getConfig()->web->name);
        $this->getView()->assign("keyword","手机赚钱方法,手机怎么赚钱");
        $this->getView()->assign("description","最新的手机赚钱方法免费分享，提供手机赚钱的技巧，让每个新手朋友快速入门。同时这里还有各类日赚项目，教你手机怎么赚钱，少走弯路，助你成功，关注天天手赚网。");

        //顶部转化页列表
        $cv=new conversionModel();
        $top_list=$cv->getConversion("article","index");
        $this->getView()->assign("top_list",$top_list);

        //获取置顶文章
        $a=new articleModel();
        $article_top_list=$a->getRecommendArticle(0,5);
        $this->getView()->assign("article_top_list",$article_top_list);

        //获取子分类
        $c=new categoryModel();
        $category_list=$c->getAllCategory();
        $this->getView()->assign("category_list",$category_list);
        
        //最近更新的文章列表
        $article_new_list=$a->getArticleList(0,1,10);
        $this->getView()->assign("article_new_list",$article_new_list);


        return true;
    }

    //文章子分类列表页
    public function listAction($categoryid,$page){
        $categoryid=intval($categoryid);
        $page=intval($page);
        $pagecount=15;//每页文章数量

        $c=new categoryModel();
        $category=$c->getCategory($categoryid);
        $this->getView()->assign("category",$category);

        $title=$category["title"];
        if($page>1){
            $title=$category["title"]."_第".$page."页-".\Yaf\Application::app()->getConfig()->web->name;
        }
        $this->getView()->assign("title",$title);
        $this->getView()->assign("keyword",$category['keyword']);
        $this->getView()->assign("description",$category['description']);

        //顶部转化页列表
        $cv=new conversionModel();
        $top_list=$cv->getConversion("article","index");
        $this->getView()->assign("top_list",$top_list);

        //置顶文章
        $a=new articleModel();
        $article_top_list=$a->getRecommendArticle($categoryid,15);
        $this->getView()->assign("article_top_list",$article_top_list);
        
        //文章列表
        $article_list=$a->getArticleList($categoryid,$page,$pagecount);
        $this->getView()->assign("article_list",$article_list);

        //获取子分类
        $category_list=$c->getAllCategory();
        $this->getView()->assign("category_list",$category_list);

        //最近更新
        $article_new_list=$a->getArticleBar($categoryid,10);
        $this->getView()->assign("article_new_list",$article_new_list);

        //翻页
        $pageplay=$a->getArticlePlayPage($categoryid,$pagecount);
        $this->getView()->assign("pageplay",$pageplay);
        $this->getView()->assign("page",$page);
        return true;
    }

    //文章详情页
    public function contentAction($id){
        $id=intval($id);
        $a=new articleModel();
        $article=$a->getArticle($id);

        $this->getView()->assign("title",$article['title']."-".\Yaf\Application::app()->getConfig()->web->name);
        $this->getView()->assign("description",$article['description']);
        $this->getView()->assign("article",$article);

        //获取所属分类
        $c=new categoryModel();
        $category=$c->getCategory($article['catid']);
        $this->getView()->assign("category",$category);

        //通过分类获取用户转化页，放在文章内容中的最下方。
        $cv=new conversionModel();
        $top_list=$cv->getConversion("article","list",$article["catid"]);
        $this->getView()->assign("top_list",$top_list);


        //面包屑导航
        $c=new categoryModel();
        $category=$c->getCategory($article['catid']);
        $mbnav=array(
            ["txt"=>"首页","link"=>Yaf\Application::app()->getConfig()->web->pcdomain,"rel"=>"nofollow"],
            ["txt"=>"赚钱方法","link"=>\Until\Url::createurl("article","index"),"rel"=>"nofollow"],
            ["txt"=>$article['title'],"link"=>"","rel"=>"nofollow"],
        );
        $this->getView()->assign("mbnav",$mbnav);



        //获取子分类
        $category_list=$c->getAllCategory();
        $this->getView()->assign("category_list",$category_list);
        
        //右侧栏本类文章推荐
        $article_new_list=$a->getArticleBar($id,10);
        $this->getView()->assign("article_new_list",$article_new_list);

        return true;
    }
}