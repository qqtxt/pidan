<?php
namespace app\controller;
use pidan\App;
class index
{
	protected $app;
	public function __construct(App $app){
		$this->app=$app;
	}
	public function phpinfo(){
		phpinfo();
		return ob_get_clean();
	}
	public function index(){
		// event('UserLogin');
		//S('test','cache_reids<br>');
		// print_r(s('test'));
		//session('sessiontest','sessiontest_ok<br>');

		// // $_SESSION['text']='text_ok';
		// // if(session_status() === PHP_SESSION_ACTIVE)
		// // {
		// // 	session_start();
		// // 	echo $_SESSION['text'];
		
		// // }
		//print_r(session('sessiontest'));
		// //db()->query('insert `{#je_#}user` (phone)value(:phone)',['phone'=>'18566125581']);
		// // echo db()->insert('user',['phone'=>'19876926580']); 
		// // echo db()->update('user',['phone'=>'19876926560'],'phone="19876926580"'); return;
		  //  $rows=db()->column('SELECT phone FROM `{#je_#}user` WHERE phone_switch=:phone_switch',array('phone_switch'=>0));
		  // print_r($rows);
		include app_path().'/tpl/index.php';
		return ob_get_clean();
	}
	function need(){
		include app_path().'/tpl/index.php';

	}

}
