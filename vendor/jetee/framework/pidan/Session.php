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
	private $redis=array();//当前session的值
	private $setcookie=null;//当前session的值
	private $sid='';//session_id
	private $pid='';//加$pre的sid  存入redis
	private $pre='s_';//存入redis的前缀
	
	//如果有sid  读   没有建  如果有cookie sid =read session memery table 
	function __construct($redis,$setcookie,$sid='') {
		$this->redis=$redis;
		$this->setcookie=$setcookie;
		if($sid) {
			$this->sid=$sid;
			$this->pid=$this->pre.$sid;
		}
		//如果不存在 创建
		if($this->pid=='' || !$redis->exists($this->pid)) {
			do{
				$this->sid=$this->random(12);
				$this->pid=$this->pre.$this->sid;
			}while($redis->exists($this->pid));
			$redis->hmset($this->pid,array('a'=>'1'));
			$redis->expire($this->pid,$expire=C('session_options.expire'));
			if(IS_CLI){
				$setcookie->cookie(C('session_options.name'),$this->sid,$expire);
			}else{
				cookie(C('session_options.name'),$this->sid,$expire);
			}
		}
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
 	function set($key, $value) {
		if($value===null){
			return $this->redis->hdel($this->pid,$key);//成功1  失败0
		}else{
			return $this->redis->hset($this->pid,$key,$value);//0修改成功   1新增成功  false失败
		}
	}
	/**
	* 取key值  或全部
	* @param string $key 标识位置
	* @param mixed  $value
	* @return mixed 0修改成功   1新增成功  false失败
	*/	
	function get($key=null) {
		if($key===null){
			return $this->redis->hgetall($this->pid);//没有值为空数组   array()
		}
		return $this->redis->hget($this->pid,$key);//没有值为false
	}
	//取所有字段名
	function keys() {
		return $this->redis->hkeys($this->pid);//没有值为空数组   array()
	}	
 	function exists($key) {
		return $this->redis->hexists($this->pid,$key);//成功true  失败false
	}

	
	//如果有用户退出或者新用户登陆  就会清除已过期的登陆不用设置radom清垃圾
	function destroy() {
		if(IS_CLI){
			$this->setcookie->cookie(C('session_options.name'),null);
		}else{
			cookie(C('session_options.name'),null);
		}
		return $this->redis->del($this->pid);
	}
	function reset() {
		$expire=C('session_options.expire');
		if(IS_CLI){
			$this->setcookie->cookie(C('session_options.name'),$this->sid,$expire);
		}else{
			cookie(C('session_options.name'),$this->sid,$expire);
		}
		return $this->redis->expire($this->pid,$expire);
	}
	/**
	 * 获取随机数
	 * @param   int		$length		获取长度
	 * @param   bool	$numeric	是纯数字，还是数字加字母
	 * @return  str		随机数串
	 */
	function random($length) {
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