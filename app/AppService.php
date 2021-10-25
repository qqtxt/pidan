<?php
declare (strict_types = 1);
namespace app;
use pidan\Service;
/**
 * 应用服务类
 */
class AppService extends Service
{
	public $bind = [//只能在此bind
		//'request'                 => Request::class,
	];
    public function register()
    {
    	echo 'AppService_register<br>';// 服务启动

        // 服务注册
    }

    public function boot()
    {
        echo 'AppService_boot<br>';// 服务启动
    }
}
