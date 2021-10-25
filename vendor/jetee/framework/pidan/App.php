<?php
declare (strict_types = 1);

namespace pidan;

/**
 * App 基础类
 */
class App extends Container
{
	const VERSION = '1.0.1';

	/**
	 * 应用调试模式
	 * @var bool
	 */
	protected $appDebug = false;

	/**
	 * 应用开始时间
	 * @var float
	 */
	protected $beginTime;

	/**
	 * 应用内存初始占用
	 * @var integer
	 */
	protected $beginMem;
	/**
	 * 应用根目录
	 * @var string
	 */
	protected $rootPath = '';

	/**
	 * 框架目录
	 * @var string
	 */
	protected $pidanPath = '';

	/**
	 * 应用目录
	 * @var string
	 */
	protected $appPath = '';

	/**
	 * Runtime目录
	 * @var string
	 */
	protected $runtimePath = '';
	/**
     * 注册的系统服务
     * @var array
     */
    protected $services = [];
	/**
	 * 初始化
	 * @var bool
	 */
	protected $initialized = false;
		/**
	 * 容器绑定标识
	 * @var array
	 */
	protected $bind = [
		'request'                 => Request::class,
        'response'                => Response::class,		
		'http'                    => Http::class,
		'event'                   => Event::class,
		'event'                   => Event::class,
        'middleware'              => Middleware::class,		
	];
	/**
	 * 架构方法
	 * @access public
	 * @param string $rootPath 应用根目录
	 */
	public function __construct(string $rootPath = '')
	{
		$this->beginTime = microtime(true);
		$this->beginMem  = memory_get_usage();
		$this->pidanPath   = dirname(__DIR__)  . '/';// /jetee/framework
		$this->rootPath    = $rootPath ? $rootPath : dirname(dirname(dirname($this->pidanPath))). '/';
		$this->appPath     = $this->rootPath . 'app' . '/';
		$this->runtimePath = $this->rootPath . 'runtime' . '/';
		static::setInstance($this);
		$this->instance('pidan\App', $this);
		$this->instance('pidan\Container', $this);

		$this->initialize();
	}
	
	/**
	 * 开启应用调试模式
	 * @access public
	 * @param bool $debug 开启应用调试模式
	 * @return $this
	 */
	public function debug(bool $debug = true)
	{
		$this->appDebug = $debug;
		return $this;
	}

	/**
	 * 是否为调试模式
	 * @access public
	 * @return bool
	 */
	public function isDebug(): bool
	{
		return $this->appDebug;
	}

   /**
	 * 获取应用根目录
	 * @access public
	 * @return string
	 */
	public function getRootPath(): string
	{
		return $this->rootPath;
	}

	/**
	 * 获取应用基础目录
	 * @access public
	 * @return string
	 */
	public function getBasePath(): string
	{
		return $this->rootPath . 'app' . DIRECTORY_SEPARATOR;
	}

	/**
	 * 获取当前应用目录
	 * @access public
	 * @return string
	 */
	public function getAppPath(): string
	{
		return $this->appPath;
	}

	/**
	 * 设置应用目录
	 * @param string $path 应用目录
	 */
	public function setAppPath(string $path)
	{
		$this->appPath = $path;
	}

	/**
	 * 获取应用运行时目录
	 * @access public
	 * @return string
	 */
	public function getRuntimePath(): string
	{
		return $this->runtimePath;
	}

	/**
	 * 设置runtime目录
	 * @param string $path 定义目录
	 */
	public function setRuntimePath(string $path): void
	{
		$this->runtimePath = $path;
	}

	/**
	 * 获取核心框架目录
	 * @access public
	 * @return string
	 */
	public function getPidanPath(): string
	{
		return $this->pidanPath;
	}

	/**
	 * 获取应用开启时间
	 * @access public
	 * @return float
	 */
	public function getBeginTime(): float
	{
		return $this->beginTime;
	}

	/**
	 * 获取应用初始内存占用
	 * @access public
	 * @return integer
	 */
	public function getBeginMem(): int
	{
		return $this->beginMem;
	}
	/**
	 * 是否运行在命令行下
	 * @return bool
	 */
	public function runningInConsole(): bool
	{
		return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
	}
	/**
     * 引导应用
     * @access public
     * @return void
     */
    public function bootService(): void
    {
        array_walk($this->services, function ($service) {
	        if (method_exists($service, 'boot')) {
	            return $this->invoke([$service, 'boot']);
	        }
        });
    }
	/**
	 * 处理事件配置文件 app/event.php
	 * @access protected
	 * @param array $event 事件数据
	 * @return void
	 */
	public function loadEvent(array $event): void
	{
		if (isset($event['bind'])) {
			$this->event->bind($event['bind']);
		}

		if (isset($event['listen'])) {
			$this->event->listenEvents($event['listen']);
		}

		if (isset($event['subscribe'])) {
			$this->event->subscribe($event['subscribe']);
		}
	}
	/**
	 * 初始化应用
	 * @access public
	 * @return $this
	 */
	public function initialize()
	{
		$this->initialized = true;
		include_once $this->pidanPath . 'helper.php';
		C(include $this->appPath.'/config.php');
		$this->appDebug = C('app_debug') ? true :false;
		ini_set('display_errors', $this->appDebug ? 'On' : 'Off');
		if (!$this->runningInConsole()) {
			//重新申请一块比较大的buffer
			if (ob_get_level() > 0) {
				$output = ob_get_clean();
			}
			ob_start();
			if (!empty($output)) {
				echo $output;
			}
		}
		
		if (is_file($this->appPath . 'common.php')) {//加载应用函数
			include_once $this->appPath. 'common.php';
		}
		if (is_file($this->appPath . 'event.php')) {
			$this->loadEvent(include $this->appPath . 'event.php');
		}
		if (is_file($this->appPath . 'service.php')) {
			$services = include $this->appPath . 'service.php';
			foreach ($services as $service) {
				$this->register($service);
			}
		}
		// 加载应用默认语言包
		//$this->loadLangPack($langSet);
		// 监听AppInit
		$this->event->trigger('AppInit');
		date_default_timezone_set(C('default_timezone'));

		$this->bootService();


		// dispatcher();
		// $app=isset($_GET['app']) ? $_GET['app'] : 'index';
		// $act=isset($_GET['act']) ? $_GET['act'] : 'index';
		// $app='app\controller\\'.$app;
		// echo $this->invokeMethod([$app,$act]);
		//$controller = new $app($act);
		

		return $this;
	}
	/**
	 * 注册服务
	 * @access public
	 * @param Service|string $service 服务
	 * @param bool           $force   强制重新注册
	 * @return Service|null
	 */
	public function register($service, bool $force = false)
	{
		$registered = $this->getService($service);//已经实例化
		if ($registered && !$force) {
			return $registered;
		}
		if (is_string($service)) {
			$service = new $service($this);
		}
		if (method_exists($service, 'register')) {
			$service->register();
		}
		if (property_exists($service, 'bind')) {
			$this->bind($service->bind);
		}
		$this->services[] = $service;
	}
	/**
	 * 给定的服务已经实例化  返回实例  否则返回null  
	 * @param string|Service $service
	 * @return Service|null
	 */
	public function getService($service)
	{
		$name = is_string($service) ? $service : get_class($service);
		return array_values(array_filter($this->services, function ($value) use ($name) {
			return $value instanceof $name;
		}, ARRAY_FILTER_USE_BOTH))[0] ?? null;
	}
}