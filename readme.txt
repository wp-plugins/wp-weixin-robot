=== WP微信机器人 ===
Contributors: midoks@163.com
Donate link: https://me.alipay.com/midoks
Tags: weixin robot
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: weixin robot
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Weixin connected to the WordPress, use the information you faster
(微信连接Wordpress,是你的传播的信息更快)
== Description ==

Weixin connected to the WordPress, use the information you faster
By weixin APP (weixin.qq.com) information coming through the wordpress plugin wp-weixin-robot call back information. 
May use the advanced interface (https://api.weixin.qq.com/).

== Installation ==

1. 上传到 `/wp-content/plugins/` 目录
1. 在后台插件菜单激活该插件
1. 在微信后台，将接口配置信息中的 URL 设置为：http://你博客地址/?midoks Token 设置为:midoks

== Frequently asked questions ==

= A question that someone might have =

An answer to that question.

== Screenshots ==

1.Menu Update 
2. 

== Changelog ==

== 微信机器人使用 ==
* 被动回复消息:

1. 回复?,返回帮助信息(在设置中可改)
2. 回复n(1-10),返回最新的图文信息
3. 回复h(1-10),返回最热门的图文信息
4. 回复r(1-10),返回随机的图文信息
5. 回复?(关键字),返回搜索关键字的5篇图文信息
6. 回复?(关键字)!?,回复关键字的有多少文章和有几页(5篇为一页)
7. 回复?(关键字)!1,返回图文信息(5篇为一页),在搜索关键字多页的情况下!
8. 回复p(数字),回复第几页的图文信息(5篇为一页)
9. 回复@,返回分类列表!(http://t.qq.com/zhoudongfei)
10, 回复#,返回标签信息(http://t.qq.com/zhoudongfei,http://weibo.com/clothand,效果是喜人的,但仅在客服端有效)

*关键字回复设置

1.有能力的，使用扩展机制实现,会更好
微信菜单回复设置

1.有能力的，使用扩展机制实现,会更好
WP微信机器人客服端聊天功能([服务号]我测试有效)

1.开启聊天模式
2.设置默认回复ID
图形化统计

有时间再优化了。
微信机器人扩展功能(有开发能力的)

阅读extends目录中readme.txt内容
检测是否能正常通信

1.有人使用了插件,却无法使用(根据我的经验测试得出,你的rewrite配置可能有错)。
2.详情请阅读:微信机器人测试.txt
程序调式

1.在设置中开启调试模式.

2.http://youdomain/?midoks&debug=true&kw=?

感谢捐助我的的人(不分先后):

周东飞、李攀、张伟丁



== Upgrade notice ==

= now =
see: http://midoks.cachecha.com/p/wordpress_plugin_weixin_robotv4-1.html

= 4.0 =
see: http://midoks.cachecha.com/p/wordpress_plugin_weixin_robotv4.html

= 3.0 =
see: http://midoks.cachecha.com/p/wordpress_plugin_weixin_robotv3.html

= 2.0 =
see: http://midoks.cachecha.com/p/wordpress_plugin_weixin_robotv2.html

= 1.0 =
see: http://midoks.cachecha.com/p/wordpress_plugin_weixin_root.html
