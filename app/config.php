<?php
//大小写一样
return [
	'datebase'=>[
		'db_name'           =>'pinhuo_jt2100_co',
		'db_host'           =>'127.0.0.1',
		'db_user'           =>'pinhuo_jt2100_co',
		'db_pwd'            =>'Mrpt6MdLbH2DZa7L',
		'db_prefix'         =>'je_',
		'db_port'           =>'3306',
	],
	/*应用配置*/
	'app'=>[
		'app_debug'             =>true,
		'default_timezone'      => 'Asia/Shanghai',
		'default_filter'        => 'trim',//I函数默认过滤
	],
	/* Cookie设置 */
    'cookie'=>[
    	'prefix'         => '', // cookie 名称前缀
		'expire'         => 0,       		// 有效期
		'domain'         => '',//defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN :'', // Cookie有效域名
		'path'           => '/',     // Cookie路径
		'secure'         => defined('IS_SSL') ?  (IS_SSL ? true : false) :'',     // Cookie路径
		'httponly'       => true,     // Cookie路径
    ],
	/* SESSION设置 */
    'session'=>[
		'expire'        => 3600*24, //过期
		'cookie_name'   => '_s_',	//cookie
		'prefix'		=> 'se_',   //redis 或其它缓冲前缀
		'type'          => 'Redis', // session hander驱动Redis  或空为系统自带
	],

	/* 数据缓存设置与页面缓冲不一样*/
    'cache'=>[
		'expire'        => NULL,      // 数据缓存有效期 NULL表示永久缓存
		'type'          => 'Redis',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator|Redis	
		'prefix'        => 'ca_',     // 缓存前缀
	],
	/* redis设置 */
	'redis'=>[
		'host'        =>'127.0.0.1',
		'port'        =>'6379',
		'password'    =>'',
		'select'      =>6,
	],

];
