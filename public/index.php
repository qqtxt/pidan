<?php
// [ 应用入口文件 ]
namespace pidan;

require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应
$getBeginTime=(new App())->initialize()->getBeginTime();
echo microtime(true)-$getBeginTime;