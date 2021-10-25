<?php
// [ 应用入口文件 ]
namespace pidan;
$getBeginTime=microtime(true);//app()->getBeginTime();
require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应
$http = (new App())->http;
$response = $http->run();
$response->send();
$http->end($response);

echo microtime(true)-$getBeginTime;