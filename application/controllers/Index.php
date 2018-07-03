<?php
/**
 * @name IndexController
 * @author notebook\mybook
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class IndexController extends BaseController {
	public function indexAction() {
		$this->getView()->assign("title","手机赚钱方法_手机赚钱软件_手机赚钱软件排行榜-".Yaf\Application::app()->getConfig()->web->name);
		$this->getView()->assign("keyword","手机赚钱方法,手机赚钱软件,手机赚钱软件排行榜");
		$this->getView()->assign("description","天天手赚网提供最新的手机赚钱方法和热门手机赚钱软件，每天更新手机赚钱软件排行榜，新手0费用起步教学，真正专业的手机赚钱平台，手机赚钱就上天天手赚网http://www.7292898.com/");

		//获取APP列表
		$a=new appModel();
		$applist=$a->getAppList("status=1","recommend","desc",5,10);
		$this->getView()->assign("applist",$applist);

		//获取推荐的手机赚钱方法文章
		$a=new articleModel();
		$article_recommend_list=$a->getRecommendArticle(0,20);
		$item_count=ceil(count($article_recommend_list) / 2);
		$article_recommend_list_p1=array_slice($article_recommend_list,0,$item_count);
		$article_recommend_list_p2=array_slice($article_recommend_list,-$item_count);
		$this->getView()->assign("article_recommend_list_p1",$article_recommend_list_p1);
		$this->getView()->assign("article_recommend_list_p2",$article_recommend_list_p2);

		//获取最近更新的文章
		$article_list=$a->getArticleList(0,0,10);
		$this->getView()->assign("article_list",$article_list);

		//获取推荐APP
		$ap=new appModel();
		$app_recommend_list=$ap->getAppList('status=1','recommend','desc',0,5);
		$this->getView()->assign("app_recommend_list",$app_recommend_list);

		//获取友情链接
		$f=new flinkModel();
		$flink_list=$f->getFlink(true);
		$this->getView()->assign("flink_list",$flink_list);


		return true;
	}

	public function sampleAction(){
		return true;
	}
}
