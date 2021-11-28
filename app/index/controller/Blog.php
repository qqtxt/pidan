<?php
namespace app\index\controller;


class Blog
{
    public function index(){
       // print_r(apcu_cache_info());
       // event('UserLogin');
        echo '11113333333311';
        return '4444444444';

    }

    public function phpinfo($name = 'ThinkPHP6')
    {
        phpinfo();
        return 'hello,' . $name;
    }
}
