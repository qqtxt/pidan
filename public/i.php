<?php 
function inner() {
	yield 1; // key 0
	yield 2; // key 1
	yield 3; // key 2
}
function gen() {
	yield 0; // key 0
	yield from inner(); // keys 0-2
	yield 4; // key 1
}
// 传递 false 作为第二个参数获得数组 [0, 1, 2, 3, 4]
var_dump(iterator_to_array(inner()));

/*

echo 1111111;

$a=[0=>1,1=>[1,2,3]];
$b=[1=>[4=>4],4=>4,5=>5,6=>6];
$c=$a+$b;
print_r($c);



$start=microtime(true);
$i=0;
while($i++<100)
@file_get_contents('./'.$i.'.txt');
echo "\n".number_format(microtime(true)-$start,9);


apcu_store('id', [],8888);
var_dump(apcu_fetch('id'));exit;

var_dump(null ?? false);exit;


$a=$_GET['a'];
$b=(int)$_GET['b'];
$redis = new Redis();
define('ENTRY',microtime(true));
if($a=='1'){
	$res=$redis->pconnect('127.0.0.1', '6379', 0, 'persistent_id_0');
	$redis->set('aaaa','aaaa');
	$i=0;
	while($i++<$b)$redis->set('aaaa',$i);
	echo $redis->get('aaaa');
}else{
	apcu_add('aaaa','aaaa');
	$i=0;
	while($i++<$b)apcu_store('aaaa',$i);	
	echo apcu_fetch('aaaa');

}
echo '<br>'.number_format(microtime(true)-ENTRY,9);







namespace pidan;
define('DEBUG',true);//为了规范程序不建议用它    程序内都用app->isDebug
apcu_clear_cache();
define('ENTRY',microtime(true));
require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应

$app = new App();
$store=$app->cache->store('apcu');
$store->set('aaaa','aaaa');
$i=0;
$a=$_GET['a'];
$b=(int)$_GET['b'];
while($i++<$b)$store->set('aaaa',$i);
echo $store->get('aaaa');
echo '<br>'.number_format(microtime(true)-ENTRY,9);
*/