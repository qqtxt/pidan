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
		'default_timezone'  => 'Asia/Shanghai1',
		'default_filter'    => 'trim',//I函数默认过滤
		'default_app'		=> 'index',
		'domain_bind'		=> [],//['huotai.xxx.com'=>'admin','admin'=>'admin'],//最好是入口文件名区分应用，  自动应用有效，安全
		// 应用映射（自动多应用模式有效）
		'app_map'          => ['index'=>'index','admin'=>'admin','*'=>'index'],
		// 禁止URL访问的应用列表（自动多应用模式有效）
		'deny_app_list'    => [],
		//开启路由
		'with_route'	  =>0,
	],
	/* Cookie设置 */
	'cookie'=>[
		'prefix'         => '',// cookie 名称前缀
		'expire'         => 0, // 有效期
		'domain'         => '',//Cookie有效域名
		'path'           => '/',// Cookie路径
		'secure'         => defined('IS_SSL') ?  (IS_SSL ? true : false) :'',
		'httponly'       => true, 
		'samesite'		 => 'lax'//防止CSRF攻击和用户追踪
	],
	/* SESSION设置 */
	'session'=>[
		'name'   		=> 'PHPSESSID1',	//cookie
		'type'          => 'apcu', // session hander驱动redis | apcu
		'expire'        => 86400, //过期
		'prefix'		=> 'ses_',   //存入redis或其它缓冲的前缀
	],
	'route'=>[
		// 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
		'request_cache_key'     => true,
		// 请求缓存有效期
		'request_cache_expire'  => 60,
		
		// 默认JSONP格式返回的处理方法
		'default_jsonp_handler' => 'jsonpReturn',
		// 默认JSONP处理方法
		'var_jsonp_handler'     => 'callback',
	],
	'lang'=>[
		// 默认语言
		'default_lang'    => 'zh-cn',
		// 允许的语言列表
		'allow_lang_list' => [],
		// 多语言自动侦测变量名
		'detect_var'      => 'lang',
		// 是否使用Cookie记录
		'use_cookie'      => true,
		// 多语言cookie变量
		'cookie_var'      => 'pidan_lang',
		// 多语言header变量
		'header_var'      => 'pidan-lang',
		// 扩展语言包
		'extend_list'     => [],
		// Accept-Language转义为对应语言包名称
		'accept_language' => [
			'zh-hans-cn' => 'zh-cn',
		],
		// 是否支持语言分组
		'allow_group'     => false,
	],
	'cache'=>[
		'default'    =>    'apcu',
		'stores'    =>    [
			// 文件缓存
			'file' => [
				// 驱动方式
				'type'       => 'File',
				// 缓存保存目录
				'path'       => '',
				// 缓存前缀
				'prefix'     => 'file_',
				// 缓存有效期 0表示永久缓存
				'expire'     => 0,
				// 缓存标签前缀
				'tag_prefix' => 'tag:',
				// 序列化机制 例如 ['serialize', 'unserialize']
				'serialize'  => [],
			],  
			// redis缓存
			'redis'   =>  [
				'type'   => 'Redis',
				'host'       => '127.0.0.1',
				'port'       => 6379,
				'password'   => '',
				'select'     => 6,
				'timeout'    => 0,//既是连接过期时间
				'expire'     => 0,//默认key过期时间
				'persistent' => true,
				'prefix'     => 'redis_',
				'tag_prefix' => 'tag:',
				'serialize'  => [],
			], 
			'apcu'   =>  [
				'type'   => 'Apcu',
				'expire'     => 0,
				'prefix'     => '',
			],  

		],
	],


];
