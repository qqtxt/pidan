<?php
route()->get('think', function () {
    return 'hello,ThinkPHP6!';
});

route()->get('hello/:name', 'index/hello');

route()->get('index/index', 'blog/index');
