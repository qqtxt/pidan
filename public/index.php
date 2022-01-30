<?php
// [ 应用入口文件 ]
namespace pidan;

define('DEBUG',1);//方便改    传递给程序内app->isDebug

define('ENTRY',microtime(true));

define('APCU_PREFIX','pidan123_');//因为没有副本  注意别共用与覆盖    改名更新  不定义无缓冲


require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
($response =($http = (new App())->http)->run())->send();

$http->end($response);


echo '<br>'.(microtime(true)-ENTRY);

//file_put_contents('timeout.txt', microtime(true)-ENTRY);

