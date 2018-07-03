<?php
/**
 * @name Bootstrap
 * @author notebook\mybook
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf\Bootstrap_Abstract{

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $arrConfig);
	}

	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
		//配置本站路由协议
		$router=Yaf\Dispatcher::getInstance()->getRouter();

		############## app ##################
		#app content
		$route=new Yaf\Route\Regex("#^/app/(\d+).html$#",array('controller'=>'app','action' => 'content'),array(1  => 'id'));
		$router->addRoute('app_content', $route);

		#app index
		$route=new Yaf\Route\Regex("#^/app/$#",array('controller'=>'app','action' => 'index'));
		$router->addRoute('app_index', $route);

		#app list
		$route=new Yaf\Route\Regex("#^/app/list-(\d+)-(\d+)-(\d+).html$#",array('controller'=>'app','action'=>'list'),array(1=>'appcategoryid',2=>'categoryid',3=>'page'));
		$router->addRoute("app_list",$route);

		################# article ########################
		#article content
		$route=new Yaf\Route\Regex("#^/article/(\d+).html$#",array('controller'=>'article','action' => 'content'),array(1  => 'id'));
		$router->addRoute('article_content', $route);

		#article list
		$route=new Yaf\Route\Regex("#^/article/(\d+)-(\d+).html$#",array('controller'=>'article','action' => 'list'),array(1  => 'categoryid',2=>'page'));
		$router->addRoute('article_list', $route);

		#article index
		$route=new Yaf\Route\Regex("#^/article/$#",array('controller'=>'article','action' => 'index'));
		$router->addRoute('article_index', $route);
		################# page ##########################
		#page show
		$route=new Yaf\Route\Regex("#^/page/([a-z]+).html$#",array('controller'=>'page','action' => 'show'),array(1=>'name'));
		$router->addRoute('page_show', $route);

	}

	public function _initView(Yaf\Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
}
