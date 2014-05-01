/* 今日文章推送功能 */
jQuery(function($){
///////////////////////////////////

function Toast(info, time){

if(typeof time == 'undefined'){
	var time = 3000;
}
var div =  document.createElement('div');
div.id = 'midoks_toast_'+((new Date()).getTime());
var t = (parseInt($('body').height())/2)+'px';
var l = (parseInt($('body').width())/2)+'px';
$('body').append(div);
$('#'+ div.id).attr('id', 'midoks_toast').addClass('button-primary').
	css('position', 'fixed').css('top', t).css('left', l).
	fadeIn(1000,function(){//淡入
	}).fadeOut(time, function(){
		$(this).remove();
	}).text(info);
}
$.fn.Toast = Toast;//对外接口

function send(op, callback){
	var op = $.extend({
		submit:1,
		page:'weixin_robot_push',
	},op);

	$.ajax({
		type:'POST',
		data:op,
		url:'../index.php',
		success:function(data){callback(data)}
	});
}


//测试推送一片最新文章
$('#send_test').click(function(){
	$.fn.Toast("已经开始传递数据了,稍等片刻...", 800);
	send({method:'send_test'}, function(data){
		console.log(data);
		$.fn.Toast(data);
	});
});
/////////////////////////////////////
});
