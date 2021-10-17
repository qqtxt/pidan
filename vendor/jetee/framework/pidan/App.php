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
     * 初始化
     * @var bool
     */
    protected $initialized = false;
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

		if (is_file($this->appPath . 'provider.php')) {
			$this->bind(include $this->appPath . 'provider.php');
		}

		static::setInstance($this);

		$this->instance('pidan\App', $this);
        $this->instance('pidan\Container', $this);


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
     * 初始化应用
     * @access public
     * @return $this
     */
    public function initialize()
    {
        $this->initialized = true;
        $this->appDebug  = true;
        define('IS_CGI',substr(PHP_SAPI, 0,3)=='cgi' ? 1 : 0 );
		define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0 );
		define('IS_CLI',PHP_SAPI=='cli'? 1   :   0);

        // 加载全局初始化文件
        if (is_file($this->appPath . 'common.php')) {
            include_once $this->appPath. 'common.php';
        }
        include_once $this->pidanPath . 'helper.php';
        C(include $this->appPath.'/config.php');
        dispatcher();
		$app=isset($_GET['app']) ? $_GET['app'] : 'index';
		$act=isset($_GET['act']) ? $_GET['act'] : 'index';
		$app='app\controller\\'.$app;
		invoke([$app,$act]);
		$controller = new $app($act);
        //date_default_timezone_set($this->config->get('app.default_timezone', 'Asia/Shanghai'));

        return $this;
    }

}