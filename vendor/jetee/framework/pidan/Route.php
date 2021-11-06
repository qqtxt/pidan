<?php
declare (strict_types = 1);

namespace pidan;

use Closure;
use pidan\route\Domain;
use pidan\route\RuleName;

/**
 * 路由管理类
 * @package pidan
 */
class Route
{
	/**
	 * 当前分组对象
	 * @var RuleGroup
	 */
	protected $group;
	
	/**
	 * 域名对象
	 * @var Domain[]
	 */
	protected $domains = [];
	
	public function __construct(App $app)
	{
		$this->app      = $app;
		$this->ruleName = new RuleName();
		$this->setDefaultDomain();
		var_dump($this->app->getRuntimePath());exit('ok');
		if (is_file($this->app->getRuntimePath() . 'route.php')) {
			// 读取路由映射文件
			$this->import(include $this->app->getRuntimePath() . 'route.php');
		}

		$this->config = array_merge($this->config, $this->app->config->get('route'));
	}
	/**
	 * 初始化默认域名
	 * @access protected
	 * @return void
	 */
	protected function setDefaultDomain(): void
	{
		// 注册默认域名
		$domain = new Domain($this);

		$this->domains['-'] = $domain;

		// 默认分组
		$this->group = $domain;
	}

}
