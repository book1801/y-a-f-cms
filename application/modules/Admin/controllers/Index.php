<?php
/**
 * @name IndexController
 * @author notebook\mybook
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class IndexController extends ManagerController {

	/**
     * 默认动作
     * Yaf支持直接把Yaf\Request\Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/Sample/index/index/index/name/notebook\mybook 的时候, 你就会发现不同
     */
	public function indexAction() {
		$this->getView()->assign("title","管理首页-".$this->adtitle);

		#计算APP数量
		$a=new appModel();
		$appcount=$a->getAppCount(false);#app总数
		$appusecount=$a->getAppCount("status=1");#app有效数量
		$appnousecount=$appcount - $appusecount;
		
		#计算文章数量
		$ar=new articleModel();
		$articlecount=$ar->getArticleListCount(0);

		#计算页面数量
		$p=new pageModel();
		$pagecount=$p->getPageCount();

		$this->getView()->assign("appcount",$appcount);
		$this->getView()->assign("appusecount",$appusecount);
		$this->getView()->assign("appnousecount",$appnousecount);
		$this->getView()->assign("articlecount",$articlecount);
		$this->getView()->assign("pagecount",$pagecount);
		return true;
	}
}
