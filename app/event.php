<?php

// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'AppInit'  => [],//[function(){echo 'AppInit事件<br/>';}],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogWrite' => [],
        'UserLogin'=>[function(){echo 'UserLogin<br/>';}]
    ],

    'subscribe' => [
    ],
];
