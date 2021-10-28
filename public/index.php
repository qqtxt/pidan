<?php
// [ 应用入口文件 ]
namespace pidan;
define('ENTRY',microtime(true));
require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应
$http = (new App())->http;
$response = $http->run();
$response->send();
$http->end($response);
echo '<br>'.(microtime(true)-ENTRY);
file_put_contents('timeout.txt', microtime(true)-ENTRY);

