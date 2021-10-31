<?php
namespace pidan;

interface Cache{
	public function get($name);
	/**
	 * 通用写入缓存
	 * @access public
	 * @param string $name 缓存变量名
	 * @param mixed $value  存储数据
	 * @param integer $expire  有效时间（秒） 必须为整形  <=0  直接过期
	 * @return boolen
	 */
	public function set($name, $value, $expire);

	/**
	 * 删除缓存
	 * @access public
	 * @param string $name 缓存变量名
	 * @return boolen
	 */
	public function rm($name);


}