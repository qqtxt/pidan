<?php
declare (strict_types = 1);

//把网址wwww.ma863.comj/blog/show/id/1 转换成$_GET参数      app=blog   act=show   id=1
function dispatcher(){
	$var=array();
	$request_uri =  trim($_SERVER['REQUEST_URI'],'/');
	$part =  pathinfo($request_uri);
	if($part['dirname'] && $request_uri!='index.php'){
		$part['dirname'].='/'.$part['filename'];
		$paths=explode('/',trim($part['dirname'],'/'));
		$var['app']=array_shift($paths);
		$var['act']=array_shift($paths);
		for($i=0;$i<count($paths)/2;$i++){
			$var[$paths[$i*2]]=$paths[$i*2+1];
		}
	}
	$_GET   =  array_merge($var,$_GET);
}
/**
 * 快速获取容器中的实例 支持依赖注入
 * @param string $name        类名或标识 默认获取当前应用实例
 * @param array  $args        参数
 * @param bool   $newInstance 是否每次创建新的实例
 * @return object|App
 */
function app(string $name = '', array $args = [], bool $newInstance = false)
{
	return $name ? pidan\App::getInstance()->make($name, $args, $newInstance) : pidan\Container::getInstance();
}
/**
 * 绑定一个类到容器
 * @param string|array $abstract 类标识、接口（支持批量绑定）
 * @param mixed        $concrete 要绑定的类、闭包或者实例
 * @return Container
 */
function bind($abstract, $concrete = null)
{
	return pidan\Container::getInstance()->bind($abstract, $concrete);
}
/**
 * 触发事件
 * @param mixed $event 事件名（或者类名）
 * @param mixed $args  参数
 * @return mixed
 */
function event($event, $args = null)
{
	return pidan\Container::getInstance()->event->trigger($event, $args);
}
/**
 * 调用反射实例化对象或者执行方法 支持依赖注入
 * @param mixed $call 类名或者callable
 * @param array $args 参数
 * @return mixed
 */
function invoke($call, array $args = [])
{
	if (is_callable($call)) {
		return pidan\Container::getInstance()->invoke($call, $args);
	}

	return pidan\Container::getInstance()->invokeClass($call, $args);
}
/**
 * 获取当前应用目录
 *
 * @param string $path
 * @return string
 */
function app_path($path = '')
{
	return app()->getAppPath() . ($path ? $path . DIRECTORY_SEPARATOR : $path);
}

/**
 * 获取应用基础目录
 *
 * @param string $path
 * @return string
 */
function base_path($path = '')
{
	return app()->getBasePath() . ($path ? $path . DIRECTORY_SEPARATOR : $path);
}
/**
 * 获取web根目录
 *
 * @param string $path
 * @return string
 */
function public_path($path = '')
{
	return app()->getRootPath() . ($path ? ltrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : $path);
}
/**
 * 获取应用运行时目录
 *
 * @param string $path
 * @return string
 */
function runtime_path($path = '')
{
	return app()->getRuntimePath() . ($path ? $path . DIRECTORY_SEPARATOR : $path);
}
/**
 * 获取项目根目录
 *
 * @param string $path
 * @return string
 */
function root_path($path = '')
{
	return app()->getRootPath() . ($path ? $path . DIRECTORY_SEPARATOR : $path);
}
function app_debug(){
	return app()->isDebug();
}
/**
 * 获取\pidan\response\Redirect对象实例
 * @param string $url  重定向地址
 * @param int    $code 状态码
 * @return \pidan\response\Redirect
 */
function redirect(string $url = '', int $code = 302): Redirect
{
	return Response::create($url, 'redirect', $code);
}

/**
 * 获取当前Request对象实例
 * @return Request
 */
function request(): \pidan\Request
{
	return app('request');
}

/**
 * 创建普通 Response 对象实例
 * @param mixed      $data   输出数据
 * @param int|string $code   状态码
 * @param array      $header 头信息
 * @param string     $type
 * @return Response
 */
function response($data = '', $code = 200, $header = [], $type = 'html'): Response
{
	return Response::create($data, $type, $code)->header($header);
}
/**
 * Session管理
 * @param string $name  session名称
 * @param mixed  $value session值
 * @return mixed
 */
function session($name = '', $value = '')
{
	$session=app('session');
	if (is_null($name)) {
		// 清除
		$session->clear();
	} elseif ('' === $name) {
		return $session->all();
	} elseif (is_null($value)) {
		// 删除
		$session->delete($name);
	} elseif ('' === $value) {
		// 判断或获取
		return 0 === strpos($name, '?') ? $session->has(substr($name, 1)) : $session->get($name);
	} else {
		// 设置
		$session->set($name, $value);
	}
}
/**
 * 获取和设置语言定义(区分大小写)
 * @param string|array $name 语言变量
 * @param string $value 语言值
 * @return mixed
 */
function L($name=null, $value=null) {
	static $_lang = array();
	// 空参数返回所有定义
	if (empty($name))
		return $_lang;
	// 判断语言获取(或设置)
	// 若不存在,直接返回
	if (is_string($name)) {
		if (!strpos($name, '.')) {
			if (is_null($value))
				return isset($_lang[$name]) ? $_lang[$name] : $name;
			$_lang[$name] = $value;
			return;
		}
		// 二维数组设置和获取支持
		$name = explode('.', $name);
		if (is_null($value))
			return isset($_lang[$name[0]][$name[1]]) ? $_lang[$name[0]][$name[1]] : $name[1];
		$_lang[$name[0]][$name[1]] = $value;
		return;
	}
	// 批量定义
	if (is_array($name))
		$_lang = array_merge($_lang, $name);
	return null; // 避免非法参数
}
/**
 * 用在单线程中 共用redis
 */
function redis(){
	static $redis=NULL;
	if($redis===NULL){
		$config=app('config')->get('redis');
		//无空闲连接，创建新连接
		$redis = new Redis();
		do{
			$res = $redis->pconnect($config['host'], intval($config['port']));
		}while(!$res);

		if ('' != $config['password']){
			$redis->auth($config['password']);
		}
		if (0 != $config['select']){
			$redis->select($config['select']);
		}		
	}
	return $redis;
}
/**
 * Cookie 设置、获取、删除      cookie('lange','zh-cn',3600)#3600秒后过期
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $options cookie参数
 * @return mixed
 */
function cookie($name, $value='', $option=null) {//$request='',$response为了兼容swoole
	$config=app()->config->get('cookie');
	/*/ 默认设置
	$config = ['prefix','expire','path','domain','secure' ,'httponly']*/
	// 参数设置(会覆盖黙认设置)
	if (!is_null($option)) {
		if (is_numeric($option))
			$option = array('expire' => $option);

		$config     = array_merge($config, array_change_key_case($option));
	}
	// 清除指定前缀的所有cookie
	if (is_null($name)) {
		if (empty($_COOKIE))
			return;
		// 要删除的cookie前缀，不指定则删除config设置的指定前缀
		$prefix = empty($value) ? $config['prefix'] : $value;
		if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
			foreach ($_COOKIE as $key => $val) {
				if (0 === stripos($key, $prefix)) {
					setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
					unset($_COOKIE[$key]);
				}
			}
		}
		return;
	}
	$name = $config['prefix'] . $name;
	if ('' === $value) {
		if(isset($_COOKIE[$name])){
			$value =    $_COOKIE[$name];
			if(0===strpos($value,'jetee:')){
				$value  =   substr($value,6);
				return array_map('urldecode',json_decode($value,true));
			}else{
				return $value;
			}
		}else{
			return null;
		}
	} else {
		if (is_null($value)) {
			setcookie($name, '', 1, $config['path'], $config['domain']);
			unset($_COOKIE[$name]); // 删除指定cookie
		} else {
			// 设置cookie
			if(is_array($value)){
				$value  = 'jetee:'.json_encode(array_map('urlencode',$value));
			}
			$expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
			setcookie($name, $value, $expire, $config['path'], $config['domain']);
			$_COOKIE[$name] = $value;
		}
	}
}
/**
 * 获取输入参数 支持过滤和默认值
 * 使用方法:
 * <code>
 * I('id',0); 获取id参数 自动判断get或者post
 * I('post.name','','htmlspecialchars'); 获取$_POST['name']
 * I('get.'); 获取$_GET
 * </code> 
 * @param string $name 变量的名称 支持指定类型
 * @param mixed $default 不存在的时候默认值
 * @param mixed $filter 参数过滤方法
 * @return mixed
 */
function I($name,$default='',$filter=null,$is_array=false) {
	if(strpos($name,'.')) { // 指定参数来源
		list($method,$name) =   explode('.',$name,2);
	}else{ // 默认为自动判断
		$method = 'param';
	}
	switch(strtolower($method)) {
		case 'get'     :   $input =& $_GET;break;
		case 'post'    :   $input =& $_POST;break;
		case 'put'     :   parse_str(file_get_contents('php://input'), $input);break;
		case 'param'   :  
			switch($_SERVER['REQUEST_METHOD']) {
				case 'POST':
					$input  =  $_POST;
					break;
				case 'PUT':
					parse_str(file_get_contents('php://input'), $input);
					break;
				default:
					$input  =  $_GET;
			}
			break;
		case 'request' :   $input =& $_REQUEST;   break;
		case 'session' :   $input =& $_SESSION;   break;
		case 'cookie'  :   $input =& $_COOKIE;    break;
		case 'server'  :   $input =& $_SERVER;    break;
		case 'globals' :   $input =& $GLOBALS;    break;
		default:
			return NULL;
	}

	if(empty($name)) { // 获取全部变量
		$data       =   $input;
	}else{ // 取值操作
		$data       =	$input[$name];
	}
	if(isset($data)){
		$filters    =   isset($filter)?$filter:app('config')->get('app.default_filter');
		$filters    =   explode(',',$filters);
		foreach($filters as $filter){
			$data   =   $is_array && is_array($data) ? array_map($filter,$data): $filter($data); // 参数过滤
		}
	}else{ // 变量默认值
		$data       =	 isset($default)?$default:NULL;
	}
	return $data;
}
