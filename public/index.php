<?php
// [ 应用入口文件 ]
namespace pidan;
//apcu_clear_cache();
//define('DEBUG',true);//为了规范程序不建议用它    程序内都用app->isDebug
define('ENTRY',microtime(true));
require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应
$http = (new App())->http;
$response = $http->name('index')->run();
$response->send();
$http->end($response);
var_dump($request->requestCache);
echo '<br>'.(microtime(true)-ENTRY);
//file_put_contents('timeout.txt', microtime(true)-ENTRY);

