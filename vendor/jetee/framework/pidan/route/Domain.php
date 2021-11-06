<?php
declare (strict_types = 1);

namespace pidan\route;



/**
 * 域名路由
 */
class Domain
{
    /**
     * 架构函数
     * @access public
     * @param  Route       $router   路由对象
     * @param  string      $name     路由域名
     * @param  mixed       $rule     域名路由
     */
    public function __construct(Route $router, string $name = null, $rule = null)
    {
        $this->router = $router;
        $this->domain = $name;
        $this->rule   = $rule;
    }


}
