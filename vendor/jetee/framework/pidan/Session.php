<?php
namespace pidan;

/**
 使用redis作session
 $sess=new session();
 $sess->set('key','2');  //要加变量改库  及var $newguest 就可
 $sess->get('key');
 */
class Session{
	//private
	protected $redis=null;
	protected $setcookie=null;//swoole cookie操作
	protected $sid='';//session_id
	protected $pid='';//加$prefix的sid  存入redis
	protected $config=['prefix'=>'','expire'=>3600,'cookie_name'=>'_s_'];
	
	//如果有sid  读   没有建  如果有cookie sid =read session memery table 
	public function __construct($setcookie='') {
		$this->redis=redis();
		$this->setcookie=$setcookie;
		$this->config=array_merge($this->config,app('config')->get('session'));
		if(PHP_SAPI == 'cli'){
			$sid=$setcookie->cookie($this->config['cookie_name']);
		}else{
			$sid=cookie($this->config['cookie_name']);
		}
		if($sid) {
			$this->sid=$sid;
			$this->pid=$this->config['prefix'].$sid;
		}
		//如果不存在 创建
		if(empty($this->sid) || !$this->redis->exists($this->pid)) {
			do{
				$this->sid=$this->random(12);
				$this->pid=$this->config['prefix'].$this->sid;
			}while($this->redis->exists($this->pid));
			//$redis->hmset($this->pid,array('a'=>'1'));
			$this->redis->expire($this->pid,$this->config['expire']);
			if(PHP_SAPI == 'cli'){
				$setcookie->cookie($this->config['cookie_name'],$this->sid,$this->config['expire']);
			}else{
				cookie($this->config['cookie_name'],$this->sid,$this->config['expire']);
			}
		}
	}
	public static function __make()
	{
		return new static();
	}
	/**
	* 设置或删除key
	* 使用方法:
	* <code>
	* set('db',NULL); // 删除key
	* </code> 
	* @param string $key 标识位置
	* @param mixed  $value
	* @return mixed 0修改成功   1新增成功  false失败
	*/
 	public function set($key, $value) {
		return $this->redis->hset($this->pid,$key,$value);//0修改成功   1新增成功  false失败
	}
	public function delete($key){
		return $this->redis->hdel($this->pid,$key);//成功1  失败0
	}
	/**
	* 取key值 
	* @param string $key 标识位置
	* @return mixed 0修改成功   1新增成功  false失败
	*/	
	public function get($key) {
		return $this->redis->hget($this->pid,$key);//没有值为false
	}
 	public function has($key) {
		return $this->redis->hexists($this->pid,$key);//成功true  失败false
	}
	public function all(){
		return $this->redis->hgetall($this->pid);//没有值为空数组   array()
	}
	//如果有用户退出或者新用户登陆  就会清除已过期的登陆不用设置radom清垃圾
	public function clear() {
		if(PHP_SAPI == 'cli'){
			$this->setcookie->cookie($this->config['cookie_name'],null);
		}else{
			cookie($this->config['cookie_name'],null);
		}
		return $this->redis->del($this->pid);
	}
	public function pull($key) {
		$return=$this->redis->hget($this->pid,$key);
		$this->delete($this->pid,$key);
		return $return;//没有值为false
	}

	//取所有字段名
	public function keys() {
		return $this->redis->hkeys($this->pid);//没有值为空数组   array()
	}	
	public function reset() {
		$this->redis->del($this->pid);
		$expire=$this->config['expire'];
		if(PHP_SAPI == 'cli'){
			$this->setcookie->cookie($this->config['cookie_name'],$this->sid,$expire);
		}else{
			cookie($this->config['cookie_name'],$this->sid,$expire);
		}
		return $this->redis->expire($this->pid,$expire);
	}
	/**
	 * 获取随机数
	 * @param   int		$length		获取长度
	 * @param   bool	$numeric	是纯数字，还是数字加字母
	 * @return  str		随机数串
	 */
	protected function random($length) {
		$seed = base_convert(md5(microtime()), 16, 35);
		$seed .= 'zZ'.strtoupper($seed);
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			mt_rand();//给种
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}

}