<?php
/**
 *  extend_name:推送模块
 *  extend_url:http://midoks.cachecha.com/
 *	author: midoks
 *	version:0.1
 *	email:midoks@163.com
 *	description: 向粉丝推送信息,群发信息(实验)
 */
class wpwx_text_push_msg{
	
	public $obj;

	public function __construct($obj){
		$this->obj = $obj;
	}

	//获取所有分组的ID
	public function get_all_group_id(){
		$list = $this->obj->getUserGroup();
		$list = json_decode($list, true);
		var_dump($list);
		$id = array();
		foreach($list['groups'] as $k=>$v){
			$id[] = $v['id'];
		}
		return $id;
	}

	//获取一次
	public function get_all_user_open_id(&$ret, $open_id = ''){
		$list = $this->obj->getUserList($open_id);
		$list = json_decode($list, true);
		if( 10000 != $list['count']){
			$ret = array_merge($ret, $list['data']['openid']);
		}else{
			$this->get_all_user_open_id($ret, $list['next_openid']);
		}
	}

	//获取所有用户
	public function get_all_user(){
		$ret = array();
		$this->get_all_user_open_id($ret);
		return $ret;
	}

	public function weixin_robot_push_today_ajax(){
		
		//ajax请求数据
		if('userlist'==$_POST['method']){
			$ai = $_POST['ai'];
			$as = $_POST['as'];
			$next_id = empty($_POST['next_id']) ?'':$_POST['next_id'];
			echo $this->getUserList($next_id);exit;
		}
	}

	//后台控制
	public function admin(){
		$this->obj->admin_menu($this, '微信消息推送', 'weixin_robot_push');
	}


	public function font(){
		$this->_push_msg();
	}

	public function _pusg_msg_ImageText(){
		include(WEIXIN_ROOT_API.'weixin_robot_api_wordpress_options.php');
		$db = new weixin_robot_api_wordpress_options($this->obj->obj);
		$list = $db->new_art(1);
		$tmp_dir = WEIXIN_PLUGINS.'push_msg/tmp/';
		foreach($list as $k=>$v){
			$img[] = $v['pic'];
			$name = basename($v['pic']);
			$c = file_get_contents($v['pic']);
			//保存为本地图片(上传微信资源时,必须要以此方式,才能上传)
			file_put_contents($tmp_dir.$name, $c);
			//上传微信资源
			$img_res = $this->obj->upload('image', $tmp_dir.$name);
			$img_res = json_decode($img_res, true);
			//上传素材
			$info[] = array(
				'thumb_media_id' => $img_res['media_id'],
				'author' => $v['author'],
				'title' => $v['title'],
				'content_source_url' => $v['link'],
				'content' => $v['content'],
				'digest' => 'digest'
			);

			//记录
			$res[] = array(
				'up_media_id' => $img_res['media_id'],
			);
		}
	
		if(!empty($info)){
			$im = $this->obj->uploadMsgImageText($info);
			$im = json_decode($im, true);
			$push_media_id = $im['media_id'];
			$user = $this->get_all_user();
			$sendAll = $this->obj->sendAll($user, $push_media_id);
			$sendAll = json_decode($sendAll);
			return $sendAll;
		}
		return false;
	}

	public function _push_msg(){
		if(isset($_POST['submit']) && ('weixin_robot_push' == $_POST['page'])){
			//var_dump($_POST);
			$res = $this->_pusg_msg_ImageText();
			if($res){
				echo json_encode($res);
			}else{
			}
			exit;
		}
	}


	public function weixin_robot_push(){		

		//群发系统自带消息		
		echo "<div id='send_test' class='button-primary'>测试推送最新一篇文章</div>";

		//加载js
		$url = dirname(WEIXIN_ROOT_NA).'/extends/push_msg/push_msg.js';
		echo "<script src='{$url}' type='text/javascript'></script>";
	}
}
?>
