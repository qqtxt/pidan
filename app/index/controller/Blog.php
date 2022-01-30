<?php
namespace app\index\controller;


class Blog
{
    public function index(){
       // print_r(apcu_cache_info());
       // event('UserLogin');
        return 'hello';

    }

    public function phpinfo($name = 'ThinkPHP6')
    {
        phpinfo();
        return 'hello,' . $name;
    }
}
