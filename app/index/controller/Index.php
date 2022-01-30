<?php
namespace app\index\controller;
use pidan\App;
use pidan\Request;
class Index
{
	protected $app;
	public function __construct(){
		$this->app=app();
	}
	public function phpinfo(){
		phpinfo();
		return ob_get_clean();
	}

	public function hello(){
		return 'hello world!';
	}

	public function index(Request $request,App $app){
// 		print_r($app->cookie->get());
// 
// 		$app->cookie->set('kkkkk',1111);
// 		event('UserLogin');
// 		$cache=app('cache');
// 		 $cache->set('test','cache_reids<br>');
// 		echo $cache->get('test');
// 		$session=$app->session;
// 		$session->set('test','session_test<br>');
// 		echo $session->get('test');
		// $db=app('db');
		// $rows=$db->column('SELECT phone FROM `{#je_#}user` WHERE phone_switch=:phone_switch',array('phone_switch'=>0));
		// print_r($rows);









		
		//print_r(app('config')->get('cache.stores.redis'));
		//echo app()->parseClass('controller','index');
		//var_dump(function_exists('apcu_fetch') && filter_var(ini_get('apc.enabled'), FILTER_VALIDATE_BOOLEAN));

		// //db()->query('insert `{#je_#}user` (phone)value(:phone)',['phone'=>'18566125581']);
		// // echo db()->insert('user',['phone'=>'19876926580']); 
		// // echo db()->update('user',['phone'=>'19876926560'],'phone="19876926580"'); return;
		  
		include app_path().'/tpl/index.php';
		return ob_get_clean();
	}
	function need(){
		include app_path().'/tpl/index.php';

	}

}
