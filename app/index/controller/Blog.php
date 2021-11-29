<?php
namespace app\index\controller;


class Blog
{
    public function index(){
       // print_r(apcu_cache_info());
       // event('UserLogin');
        echo 'Blog';
        return '111111111<br>';

    }

    public function phpinfo($name = 'ThinkPHP6')
    {
        phpinfo();
        return 'hello,' . $name;
    }
}
