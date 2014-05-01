<?php
//@ WP微信机器人|锁机制实现
//author: midoks
//email: midoks@163.com
//你们有福了,我也使用的BAE
class wp_weixin_memcache_bae_lock{

	public $linkID = null;
	public $obj = null;

	public $save_time = null;
	public $expired_time = null;


	public $prefix = 'mwpwx_';

	public $conf = array(
		'cacheid' => 'pPdkLzIvgBaHmqYJvQSZ',
		'host'=>'cache.duapp.com',
		'port' => 20243,
		'user' => 'urtegxzMPVigNEyOqF7yzg7C9',
		'pwd'=>'1eojDqKZ7fUweGFDfedLzwPY4YAQURFGYM',
	);

	public function __construct(){
		$this->save_time = 30*60;
		$this->expired_time = time() + $this->save_time;
		$this->init_connect();
	}

	public function set_obj($obj){
		$this->obj = $obj;
	}

	private function _pfx($name){
		return $this->prefix.$name;
	}

	public function init_connect(){
		include_once(dirname(__FILE__).'/CacheSdk/BaeMemcache.class.php');
		if(!class_exists('BaeMemcache')){
			exit('你没有使用BaeMemcache类!!!');
		}
		$this->linkID = new BaeMemcache($this->conf['cacheid'],
			$this->conf['host'].':'.$this->conf['port'], 
			$this->conf['user'], $this->conf['pwd']);
	}

	public function check_lock(){
		$info = $this->obj->info;
		$user_id = $info['FromUserName'];
		$data = $this->linkID->get($this->_pfx($user_id));	
		if($data){
			return $data;
		}
		return false;
	}

	public function lock_content($file, $content=''){
		if(empty($content)){$content = 'midoks';}
		$info = $this->obj->info;
		$user_id = $info['FromUserName'];
		$data = $this->linkID->get($this->_pfx($user_id));
		//var_dump($data);
		if(!$data){
			$insert_content[] = $content;
			$data['lock_content'] = $insert_content;
			$data['lock_ex'] = $file;
			$data['expired_time'] = $this->expired_time;
			$b = $this->linkID->set($this->_pfx($user_id), $data, 0, $this->save_time);
			if($b) return $b;
			else return false;
		}else{
			return true;
		}
	}


	public function add_lock_content($content){
		if(is_null($content)) return false;
		$info = $this->obj->info;
		$user_id = $info['FromUserName'];
		$data = $this->linkID->get($this->_pfx($user_id));
		if(empty($data)){
			return false;
		}else{
			array_push($data['lock_content'], $content);
			$data['lock_content'] = $data['lock_content'];
			$data['expired_time'] = $this->expired_time;

			$b = $this->linkID->replace($this->_pfx($user_id), $data, 0, $this->save_time);
			if($b) return $b;
			else return false;
		}	
	}

	public function delete_lock(){
		$info = $this->obj->info;
		$user_id = $info['FromUserName'];
		return $this->linkID->delete($this->_pfx($user_id));
	}

	public function exit_lock(){
		return $this->delete_lock();
	}


	private function cache_get_lock_info(){
		if($this->cache_get_lock_info){
			return $this->cache_get_lock_info;
		}else{
			$info = $this->obj->info;
			$user_id = $info['FromUserName'];
			$data = $this->linkID->get($this->_pfx($user_id));
			$ndata = $data['lock_content'];
			$this->cache_get_lock_info = $ndata;
			return $ndata;
		}
	}

	//获取当前的位置
	public function get_lock_pos($pos = ''){
		$data = $this->cache_get_lock_info();
		if(is_int($pos)){
			$pdata = $data[$pos];
			if($pdata) return $pdata;
			else return false;
		}
		return count($data);
	}

	public function get_lock_current_data(){
		return $this->get_lock_pos($this->get_lock_pos()-1);
	}

	public function get_lock_data(){
		$data = $this->cache_get_lock_info();
		if($data){return $data;}else{return false;}
	}
}
?>
