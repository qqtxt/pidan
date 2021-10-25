<?php
declare (strict_types = 1);
namespace pidan;
use Closure;
/**
 * 系统服务基础类
 * @method void register()
 * @method void boot()
 */
abstract class Service
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

}
