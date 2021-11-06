<?php
declare (strict_types = 1);

namespace pidan\route;

use pidan\App;
use pidan\Container;
use pidan\Request;
use pidan\Response;

/**
 * 路由调度基础类
 */
abstract class Dispatch
{
	/**
	 * 应用对象
	 * @var \pidan\App
	 */
	protected $app;

	/**
	 * 请求对象
	 * @var Request
	 */
	protected $request;

	/**
	 * 路由规则
	 * @var Rule
	 */
	protected $rule;

	/**
	 * 调度信息
	 * @var mixed
	 */
	protected $dispatch;

	/**
	 * 路由变量
	 * @var array
	 */
	protected $param;

	public function __construct(Request $request, Rule $rule, $dispatch, array $param = [])
	{
		$this->request  = $request;
		$this->rule     = $rule;
		$this->dispatch = $dispatch;
		$this->param    = $param;
	}


}
