<?php
declare (strict_types = 1);
namespace pidan;
/**
 * Web应用管理类
 * @package pidan
 */
class Http
{
	/**
	 * @var App
	 */
	protected $app;

	/**
	 * 应用名称
	 * @var string
	 */
	protected $name;

	/**
	 * 应用路径
	 * @var string
	 */
	protected $path;

	/**
	 * 是否绑定应用
	 * @var bool
	 */
	protected $isBind = false;

	public function __construct(App $app)
	{
		$this->app = $app;
	}

	/**
	 * 设置应用名称
	 * @access public
	 * @param string $name 应用名称
	 * @return $this
	 */
	public function name(string $name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * 获取应用名称
	 * @access public
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name ?: '';
	}

	/**
	 * 设置应用目录
	 * @access public
	 * @param string $path 应用目录
	 * @return $this
	 */
	public function path(string $path)
	{
		if (substr($path, -1) != DIRECTORY_SEPARATOR) {
			$path .= DIRECTORY_SEPARATOR;
		}

		$this->path = $path;
		return $this;
	}

	/**
	 * 获取应用路径
	 * @access public
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path ?: '';
	}

	/**
	 * 设置应用绑定
	 * @access public
	 * @param bool $bind 是否绑定
	 * @return $this
	 */
	public function setBind(bool $bind = true)
	{
		$this->isBind = $bind;
		return $this;
	}

	/**
	 * 是否绑定应用
	 * @access public
	 * @return bool
	 */
	public function isBind(): bool
	{
		return $this->isBind;
	}

	/**
	 * 执行应用程序
	 * @access public
	 * @param Request|null $request
	 * @return Response
	 */
	public function run(): Response
	{
		//自动创建request对象
		$request = $this->app->make('request');
		// 加载全局中间件
		if (is_file($this->app->getBasePath() . 'middleware.php')) {
			$this->app->middleware->import(include $this->app->getBasePath() . 'middleware.php');
		}

		// 监听HttpRun
		$this->app->event->trigger('HttpRun');
		$this->app->G('Http');
		//https://www.ma863.com/blog/show/id/220.html  分解
		return $this->app->middleware->pipeline()
			->send($request)
			->then(function ($request) {
				$this->app->G('controllerBigin');
				dispatcher();
				$app=isset($_GET['app']) ? $_GET['app'] : 'index';
				$act=isset($_GET['act']) ? $_GET['act'] : 'index';
				$app='app\controller\\'.$app;
				//$response=Response::create((new $app($this->app))->$act());
				$response=Response::create($this->app->invokeMethod([$app,$act]));
				$this->app->G('controllerEnd');
				return $response;
			});
	}





	/**
	 * HttpEnd
	 * @param Response $response
	 * @return void
	 */
	public function end(Response $response): void
	{
		$this->app->event->trigger('HttpEnd',$response);

		//执行中间件
		$this->app->middleware->end($response);

		// 写入日志
		//$this->app->log->save();
	}

}
