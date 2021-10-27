<?php
// [ 应用入口文件 ]
namespace pidan;
$begin=microtime(true);
require __DIR__ . '/../../vendor/autoload.php';
// 执行HTTP应用并响应
$http = (new App())->http;
print_r(app('request')->pathinfo());exit;
$response = $http->run();
$response->send();
$http->end($response);
echo '<br>'.(microtime(true)-app()->G('?begin'));
echo '<br>'.number_format($begin-app()->G('?begin'),8);
file_put_contents('timeout.txt', microtime(true)-app()->G('?begin'));

