<?php
declare (strict_types = 1);
namespace app;
use pidan\Service;
use pidan\helper\Str;
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
        // 服务注册
        $app=app();
    	$type=$app->config->get('session.type');
        $app->bind('session','pidan\\session\\' . Str::studly($type));
    }

    public function boot()
    {
        //echo 'AppService_boot<br>';// 服务启动
    }
}
