<?php
//大小写一样
return array(
	'db_name'           =>'pinhuo_jt2100_co',
	'db_host'           =>'127.0.0.1',
	'db_user'           =>'pinhuo_jt2100_co',
	'db_pwd'            =>'Mrpt6MdLbH2DZa7L',
	'db_prefix'         =>'je_',
    'db_port'           =>'3306',
	
	
    /* Cookie设置 */
    'cookie_expire'         => 0,       		// 有效期
    //'COOKIE_DOMAIN'         => defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN :'', // Cookie有效域名
    'cookie_path'           => '/',     // Cookie路径
    'cookie_secure'         => defined('IS_SSL') ?  (IS_SSL ? true : false) :'',     // Cookie路径
    'cookie_httponly'       => true,     // Cookie路径
	
    /* SESSION设置 */
    'session_options'       => array('expire'=>3600*24,'name'=>'_s_'), // session 配置数组 支持expire name domain 等参数 'domain'=>defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN :''
    'session_type'          => 'Redis', // session hander驱动Redis  或空为系统自带
    /* 数据缓存设置 */
    'data_cache_time'       => NULL,      // 数据缓存有效期 NULL表示永久缓存
    'data_cache_type'       => 'Redis',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator|Redis	
   	'data_cache_prefix'     => 'c_',     // 缓存前缀

	/* redis设置 */
	'redis_host'		=>'127.0.0.1',
	'redis_port'		=>'6379',
	'redis_password'	=>'',
	'redis_select'		=>6,	
);
