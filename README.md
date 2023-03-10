#安装说明
框架用git clone git@github.com:zhh2100/pidan.git  

然后 composer install  

#库设计,以库内为准 这里为辅
##MYSQL结构	
``` sql
DROP TABLE IF EXISTS `je_ad`;
CREATE TABLE IF NOT EXISTS `je_ad` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `position` varchar(20) NOT NULL DEFAULT '' COMMENT '广告位置',
  `media` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '广告类型:1=图片,2=视频,3=代码,4=文字',
  `title` varchar(60) NOT NULL COMMENT '广告标题',
  `link` varchar(255) NOT NULL COMMENT '广告链接地址',
  `content` text NOT NULL COMMENT '广告内容',
  `starttime` int(11) NOT NULL DEFAULT '0' COMMENT '广告开始时间',
  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '广告结束时间',
  `contact` varchar(60) NOT NULL COMMENT '广告联系人',
  `email` varchar(60) NOT NULL COMMENT '联系人邮箱',
  `mobile` varchar(60) NOT NULL COMMENT '联系人电话',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `position` (`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `je_count`;
CREATE TABLE IF NOT EXISTS `je_count` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `target` enum('article','blog','code','comment') NOT NULL DEFAULT 'article' COMMENT '对应表',
  `type` enum('view','comment','digg','collect') NOT NULL DEFAULT 'view' COMMENT '类型',
  `target_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '目标ID',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '计数',
  PRIMARY KEY (`id`),
  KEY `target` (`target`,`type`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='计数';

DROP TABLE IF EXISTS `je_blog`;
CREATE TABLE IF NOT EXISTS `je_blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title` varchar(140) NOT NULL DEFAULT '' COMMENT '标题{*测试注释*}',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `tags` varchar(30) NOT NULL DEFAULT '' COMMENT 'TAG',
  `editor` enum('ueditor','tinymce','editormd') NOT NULL DEFAULT 'tinymce' COMMENT '编辑器',
  `content` mediumtext NOT NULL COMMENT '文章内容',
  `weigh` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序{*降序*}',
  `visibility` enum('all','self') NOT NULL DEFAULT 'all' COMMENT '可见:all=所有人,self=仅自己',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='博客';

DROP TABLE IF EXISTS `je_article`;
CREATE TABLE IF NOT EXISTS `je_article` (
	`id` 			int(11) unsigned NOT NULL AUTO_INCREMENT			COMMENT 'ID',
	`category_id`	int(11) unsigned NOT NULL DEFAULT '0'				COMMENT '分类ID',
	`title`			varchar(150) NOT NULL DEFAULT ''					COMMENT '标题',
	`content`		mediumtext 											COMMENT '内容',
	`author`		varchar(30) NOT NULL DEFAULT ''						COMMENT '作者',
	`keywords`		varchar(255) NOT NULL DEFAULT ''					COMMENT '关键字',
	`description`	varchar(255) NOT NULL DEFAULT ''					COMMENT '描述',
	`link`			varchar(255) NOT NULL 	DEFAULT ''					COMMENT '转发',
	`weigh`			int(11) unsigned NOT NULL DEFAULT '0'				COMMENT '权重',
	`createtime` 	int(11) unsigned NOT NULL DEFAULT '0'  				COMMENT '创建时间',
	`status` 		enum('normal','hidden') NOT NULL DEFAULT 'normal' 	COMMENT '状态',
	PRIMARY KEY (`id`),
	KEY `category_id` (`category_id`),
	KEY `weigh` (`weigh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1					COMMENT='文章';

DROP TABLE IF EXISTS `je_category`;
CREATE TABLE IF NOT EXISTS `je_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` enum('default','page','article','blog','code') NOT NULL DEFAULT 'default' COMMENT '栏目类型',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT 'classname',
  `flag` set('hot','index','recommend') NOT NULL DEFAULT '' COMMENT '推荐',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `diyname` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义名称',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `weigh` (`weigh`,`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1;
INSERT INTO `je_category` (`id`, `pid`, `type`, `name`, `nickname`, `flag`, `image`, `keywords`, `description`, `diyname`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, 0, 'page', '系统文章', 'system_article', '', '/assets/img/qrcode.png', '', '', '', 1644226911, 1644226911, 2, 'normal'),
(2, 0, 'blog', '默认分类', 'blog_mrfl', '', '/assets/img/qrcode.png', '', '', '', 1644227036, 1644227036, 1, 'normal');


DROP TABLE IF EXISTS `je_admin`;
CREATE TABLE IF NOT EXISTS `je_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(30) NOT NULL DEFAULT '' COMMENT '密码盐',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `loginfailure` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '失败次数',
  `logintime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '登录时间',
  `loginip` char(15) NOT NULL DEFAULT '' COMMENT '登录IP',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '更新时间',
  `token` varchar(59) NOT NULL DEFAULT '' COMMENT 'Session标识',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=2 ;

INSERT INTO `je_admin` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `email`, `loginfailure`, `logintime`, `loginip`, `createtime`, `updatetime`, `token`, `status`) VALUES
(1, 'admin', 'Admin', 'a0da962a33943326c8bddfc7709dbb21', 'c8c520', 'http://fast.ma863.cc/assets/img/avatar.png', 'admin@admin.com', 0, 1644097883, '127.0.0.1', 1491635035, 1644097883, 'af1964d4-d5fc-4efb-8732-afc48df27e15', 'normal');


DROP TABLE IF EXISTS `je_admin_log`;
CREATE TABLE IF NOT EXISTS `je_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名字',
  `url` varchar(1500) NOT NULL DEFAULT '' COMMENT '操作页面',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '日志标题',
  `content` longtext NOT NULL COMMENT '内容',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'User-Agent',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `name` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员日志表' AUTO_INCREMENT=2;
INSERT INTO `je_admin_log` (`id`, `admin_id`, `username`, `url`, `title`, `content`, `ip`, `useragent`, `createtime`) VALUES
(1, 0, 'Unknown', '/tqjMkcCiyI.php/index/login', '', '{"__token__":"***","username":"admin","password":"***","captcha":"hkwb"}', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36 UOS', 1644097872);


DROP TABLE IF EXISTS `je_auth_group`;
CREATE TABLE IF NOT EXISTS `je_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父组别',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `rules` text NOT NULL COMMENT '规则ID',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='分组表' AUTO_INCREMENT=6 ;
INSERT INTO `je_auth_group` (`id`, `pid`, `name`, `rules`, `createtime`, `updatetime`, `status`) VALUES
(1, 0, 'Admin group', '*', 1491635035, 1491635035, 'normal'),
(2, 1, 'Second group', '13,14,16,15,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,40,41,42,43,44,45,46,47,48,49,50,55,56,57,58,59,60,61,62,63,64,65,1,9,10,11,7,6,8,2,4,5', 1491635035, 1491635035, 'normal'),
(3, 2, 'Third group', '1,4,9,10,11,13,14,15,16,17,40,41,42,43,44,45,46,47,48,49,50,55,56,57,58,59,60,61,62,63,64,65,5', 1491635035, 1491635035, 'normal'),
(4, 1, 'Second group 2', '1,4,13,14,15,16,17,55,56,57,58,59,60,61,62,63,64,65', 1491635035, 1491635035, 'normal'),
(5, 2, 'Third group 2', '1,2,6,7,8,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', 1491635035, 1491635035, 'normal');


DROP TABLE IF EXISTS `je_auth_group_access`;
CREATE TABLE IF NOT EXISTS `je_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '会员ID',
  `group_id` int(10) unsigned NOT NULL COMMENT '级别ID',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分组表';
INSERT INTO `je_auth_group_access` (`uid`, `group_id`) VALUES(1, 1);


DROP TABLE IF EXISTS `je_auth_rule`;
CREATE TABLE IF NOT EXISTS `je_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('menu','file') NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '规则URL',
  `condition` varchar(255) NOT NULL DEFAULT '' COMMENT '条件',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  `menutype` enum('addtabs','blank','dialog','ajax') DEFAULT NULL COMMENT '菜单类型',
  `extend` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展属性',
  `py` varchar(30) NOT NULL DEFAULT '' COMMENT '拼音首字母',
  `pinyin` varchar(100) NOT NULL DEFAULT '' COMMENT '拼音',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `pid` (`pid`),
  KEY `weigh` (`weigh`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='节点表' AUTO_INCREMENT=85 ;
INSERT INTO `je_auth_rule` (`id`, `type`, `pid`, `name`, `title`, `icon`, `url`, `condition`, `remark`, `ismenu`, `menutype`, `extend`, `py`, `pinyin`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, 'file', 0, 'dashboard', 'Dashboard', 'fa fa-dashboard', '', '', 'Dashboard tips', 1, NULL, '', 'kzt', 'kongzhitai', 1491635035, 1491635035, 143, 'normal'),
(2, 'file', 0, 'general', 'General', 'fa fa-cogs', '', '', '', 1, NULL, '', 'cggl', 'changguiguanli', 1491635035, 1491635035, 137, 'normal'),
(3, 'file', 0, 'category', 'Category', 'fa fa-leaf', '', '', 'Category tips', 0, NULL, '', 'flgl', 'fenleiguanli', 1491635035, 1491635035, 119, 'normal'),
(4, 'file', 0, 'addon', 'Addon', 'fa fa-rocket', '', '', 'Addon tips', 1, NULL, '', 'cjgl', 'chajianguanli', 1491635035, 1491635035, 0, 'normal'),
(5, 'file', 0, 'auth', 'Auth', 'fa fa-group', '', '', '', 1, NULL, '', 'qxgl', 'quanxianguanli', 1491635035, 1491635035, 99, 'normal'),
(6, 'file', 2, 'general/config', 'Config', 'fa fa-cog', '', '', 'Config tips', 1, NULL, '', 'xtpz', 'xitongpeizhi', 1491635035, 1491635035, 60, 'normal'),
(7, 'file', 2, 'general/attachment', 'Attachment', 'fa fa-file-image-o', '', '', 'Attachment tips', 1, NULL, '', 'fjgl', 'fujianguanli', 1491635035, 1491635035, 53, 'normal'),
(8, 'file', 2, 'general/profile', 'Profile', 'fa fa-user', '', '', '', 1, NULL, '', 'grzl', 'gerenziliao', 1491635035, 1491635035, 34, 'normal'),
(9, 'file', 5, 'auth/admin', 'Admin', 'fa fa-user', '', '', 'Admin tips', 1, NULL, '', 'glygl', 'guanliyuanguanli', 1491635035, 1491635035, 118, 'normal'),
(10, 'file', 5, 'auth/adminlog', 'Admin log', 'fa fa-list-alt', '', '', 'Admin log tips', 1, NULL, '', 'glyrz', 'guanliyuanrizhi', 1491635035, 1491635035, 113, 'normal'),
(11, 'file', 5, 'auth/group', 'Group', 'fa fa-group', '', '', 'Group tips', 1, NULL, '', 'jsz', 'juesezu', 1491635035, 1491635035, 109, 'normal'),
(12, 'file', 5, 'auth/rule', 'Rule', 'fa fa-bars', '', '', 'Rule tips', 1, NULL, '', 'cdgz', 'caidanguize', 1491635035, 1491635035, 104, 'normal'),
(13, 'file', 1, 'dashboard/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 136, 'normal'),
(14, 'file', 1, 'dashboard/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 135, 'normal'),
(15, 'file', 1, 'dashboard/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 133, 'normal'),
(16, 'file', 1, 'dashboard/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 134, 'normal'),
(17, 'file', 1, 'dashboard/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 132, 'normal'),
(18, 'file', 6, 'general/config/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 52, 'normal'),
(19, 'file', 6, 'general/config/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 51, 'normal'),
(20, 'file', 6, 'general/config/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 50, 'normal'),
(21, 'file', 6, 'general/config/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 49, 'normal'),
(22, 'file', 6, 'general/config/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 48, 'normal'),
(23, 'file', 7, 'general/attachment/index', 'View', 'fa fa-circle-o', '', '', 'Attachment tips', 0, NULL, '', '', '', 1491635035, 1491635035, 59, 'normal'),
(24, 'file', 7, 'general/attachment/select', 'Select attachment', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 58, 'normal'),
(25, 'file', 7, 'general/attachment/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 57, 'normal'),
(26, 'file', 7, 'general/attachment/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 56, 'normal'),
(27, 'file', 7, 'general/attachment/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 55, 'normal'),
(28, 'file', 7, 'general/attachment/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 54, 'normal'),
(29, 'file', 8, 'general/profile/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 33, 'normal'),
(30, 'file', 8, 'general/profile/update', 'Update profile', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 32, 'normal'),
(31, 'file', 8, 'general/profile/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 31, 'normal'),
(32, 'file', 8, 'general/profile/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 30, 'normal'),
(33, 'file', 8, 'general/profile/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 29, 'normal'),
(34, 'file', 8, 'general/profile/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 28, 'normal'),
(35, 'file', 3, 'category/index', 'View', 'fa fa-circle-o', '', '', 'Category tips', 0, NULL, '', '', '', 1491635035, 1491635035, 142, 'normal'),
(36, 'file', 3, 'category/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 141, 'normal'),
(37, 'file', 3, 'category/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 140, 'normal'),
(38, 'file', 3, 'category/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 139, 'normal'),
(39, 'file', 3, 'category/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 138, 'normal'),
(40, 'file', 9, 'auth/admin/index', 'View', 'fa fa-circle-o', '', '', 'Admin tips', 0, NULL, '', '', '', 1491635035, 1491635035, 117, 'normal'),
(41, 'file', 9, 'auth/admin/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 116, 'normal'),
(42, 'file', 9, 'auth/admin/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 115, 'normal'),
(43, 'file', 9, 'auth/admin/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 114, 'normal'),
(44, 'file', 10, 'auth/adminlog/index', 'View', 'fa fa-circle-o', '', '', 'Admin log tips', 0, NULL, '', '', '', 1491635035, 1491635035, 112, 'normal'),
(45, 'file', 10, 'auth/adminlog/detail', 'Detail', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 111, 'normal'),
(46, 'file', 10, 'auth/adminlog/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 110, 'normal'),
(47, 'file', 11, 'auth/group/index', 'View', 'fa fa-circle-o', '', '', 'Group tips', 0, NULL, '', '', '', 1491635035, 1491635035, 108, 'normal'),
(48, 'file', 11, 'auth/group/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 107, 'normal'),
(49, 'file', 11, 'auth/group/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 106, 'normal'),
(50, 'file', 11, 'auth/group/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 105, 'normal'),
(51, 'file', 12, 'auth/rule/index', 'View', 'fa fa-circle-o', '', '', 'Rule tips', 0, NULL, '', '', '', 1491635035, 1491635035, 103, 'normal'),
(52, 'file', 12, 'auth/rule/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 102, 'normal'),
(53, 'file', 12, 'auth/rule/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 101, 'normal'),
(54, 'file', 12, 'auth/rule/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 100, 'normal'),
(55, 'file', 4, 'addon/index', 'View', 'fa fa-circle-o', '', '', 'Addon tips', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(56, 'file', 4, 'addon/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(57, 'file', 4, 'addon/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(58, 'file', 4, 'addon/del', 'Delete', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(59, 'file', 4, 'addon/downloaded', 'Local addon', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(60, 'file', 4, 'addon/state', 'Update state', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(63, 'file', 4, 'addon/config', 'Setting', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(64, 'file', 4, 'addon/refresh', 'Refresh', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(65, 'file', 4, 'addon/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(66, 'file', 0, 'user', 'User', 'fa fa-user-circle', '', '', '', 1, NULL, '', 'hygl', 'huiyuanguanli', 1491635035, 1491635035, 0, 'normal'),
(67, 'file', 66, 'user/user', 'User', 'fa fa-user', '', '', '', 1, NULL, '', 'hygl', 'huiyuanguanli', 1491635035, 1491635035, 0, 'normal'),
(68, 'file', 67, 'user/user/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(69, 'file', 67, 'user/user/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(70, 'file', 67, 'user/user/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(71, 'file', 67, 'user/user/del', 'Del', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(72, 'file', 67, 'user/user/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(73, 'file', 66, 'user/group', 'User group', 'fa fa-users', '', '', '', 1, NULL, '', 'hyfz', 'huiyuanfenzu', 1491635035, 1491635035, 0, 'normal'),
(74, 'file', 73, 'user/group/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(75, 'file', 73, 'user/group/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(76, 'file', 73, 'user/group/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(77, 'file', 73, 'user/group/del', 'Del', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(78, 'file', 73, 'user/group/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(79, 'file', 66, 'user/rule', 'User rule', 'fa fa-circle-o', '', '', '', 1, NULL, '', 'hygz', 'huiyuanguize', 1491635035, 1491635035, 0, 'normal'),
(80, 'file', 79, 'user/rule/index', 'View', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(81, 'file', 79, 'user/rule/del', 'Del', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(82, 'file', 79, 'user/rule/add', 'Add', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(83, 'file', 79, 'user/rule/edit', 'Edit', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal'),
(84, 'file', 79, 'user/rule/multi', 'Multi', 'fa fa-circle-o', '', '', '', 0, NULL, '', '', '', 1491635035, 1491635035, 0, 'normal');

DROP TABLE IF EXISTS `je_attachment`;
CREATE TABLE IF NOT EXISTS `je_attachment` (
	`id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`category` varchar(50) NOT NULL DEFAULT '' COMMENT '类别',
	`admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
	`user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
	`url` varchar(255) NOT NULL DEFAULT '' COMMENT '物理路径',
	`imagewidth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '宽度',
	`imageheight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '高度',
	`imagetype` varchar(30) NOT NULL DEFAULT '' COMMENT '图片类型',
	`imageframes` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '图片帧数',
	`filename` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名称',
	`filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
	`mimetype` varchar(100) NOT NULL DEFAULT '' COMMENT 'mime类型',
	`extparam` varchar(255) NOT NULL DEFAULT '' COMMENT '透传数据',
	`createtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '创建日期',
	`updatetime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '更新时间',
	`uploadtime` int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '上传时间',
	`storage` varchar(100) NOT NULL NOT NULL DEFAULT 'local' COMMENT '存储位置',
	`sha1` varchar(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=2 ;
INSERT INTO `je_attachment` (`id`, `category`, `admin_id`, `user_id`, `url`, `imagewidth`, `imageheight`, `imagetype`, `imageframes`, `filename`, `filesize`, `mimetype`, `extparam`, `createtime`, `updatetime`, `uploadtime`, `storage`, `sha1`) VALUES
(1, '', 1, 0, '/assets/img/qrcode.png', '150', '150', 'png', 0, 'qrcode.png', 21859, 'image/png', '', 1491635035, 1491635035, 1491635035, 'local', '17163603d0263e4838b9387ff2cd4877e8b018f6');

DROP TABLE IF EXISTS `je_config`;
CREATE TABLE IF NOT EXISTS `je_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '变量名',
  `group` varchar(30) NOT NULL DEFAULT '' COMMENT '分组',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '变量标题',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '变量描述',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型:string,text,int,bool,array,datetime,date,file',
  `visible` varchar(255) NOT NULL DEFAULT '' COMMENT '可见条件',
  `value` text NOT NULL COMMENT '变量值',
  `content` text NOT NULL COMMENT '变量字典数据',
  `rule` varchar(100) NOT NULL DEFAULT '' COMMENT '验证规则',
  `extend` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展属性',
  `setting` varchar(255) DEFAULT '' COMMENT '配置',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统配置' AUTO_INCREMENT=19 ;
INSERT INTO `je_config` (`id`, `name`, `group`, `title`, `tip`, `type`, `visible`, `value`, `content`, `rule`, `extend`, `setting`) VALUES
(1, 'name', 'basic', 'Site name', '请填写站点名称', 'string', '', '我的网站', '', 'required', '', ''),
(2, 'beian', 'basic', 'Beian', '粤ICP备15000000号-1', 'string', '', '', '', '', '', ''),
(3, 'cdnurl', 'basic', 'Cdn url', '如果全站静态资源使用第三方云储存请配置该值', 'string', '', '', '', '', '', ''),
(4, 'version', 'basic', 'Version', '如果静态资源有变动请重新配置该值', 'string', '', '1.0.1', '', 'required', '', ''),
(5, 'timezone', 'basic', 'Timezone', '', 'string', '', 'Asia/Shanghai', '', 'required', '', ''),
(6, 'forbiddenip', 'basic', 'Forbidden ip', '一行一条记录', 'text', '', '', '', '', '', ''),
(7, 'languages', 'basic', 'Languages', '', 'array', '', '{\"backend\":\"zh-cn\",\"frontend\":\"zh-cn\"}', '', 'required', '', ''),
(8, 'fixedpage', 'basic', 'Fixed page', '请尽量输入左侧菜单栏存在的链接', 'string', '', 'dashboard', '', 'required', '', ''),
(9, 'categorytype', 'dictionary', 'Category type', '', 'array', '', '{\"default\":\"Default\",\"page\":\"Page\",\"article\":\"Article\",\"test\":\"Test\"}', '', '', '', ''),
(10, 'configgroup', 'dictionary', 'Config group', '', 'array', '', '{\"basic\":\"Basic\",\"email\":\"Email\",\"dictionary\":\"Dictionary\",\"user\":\"User\",\"example\":\"Example\"}', '', '', '', ''),
(11, 'mail_type', 'email', 'Mail type', '选择邮件发送方式', 'select', '', '1', '[\"请选择\",\"SMTP\"]', '', '', ''),
(12, 'mail_smtp_host', 'email', 'Mail smtp host', '错误的配置发送邮件会导致服务器超时', 'string', '', 'smtp.qq.com', '', '', '', ''),
(13, 'mail_smtp_port', 'email', 'Mail smtp port', '(不加密默认25,SSL默认465,TLS默认587)', 'string', '', '465', '', '', '', ''),
(14, 'mail_smtp_user', 'email', 'Mail smtp user', '（填写完整用户名）', 'string', '', '10000', '', '', '', ''),
(15, 'mail_smtp_pass', 'email', 'Mail smtp password', '（填写您的密码或授权码）', 'string', '', 'password', '', '', '', ''),
(16, 'mail_verify_type', 'email', 'Mail vertify type', '（SMTP验证方式[推荐SSL]）', 'select', '', '2', '[\"无\",\"TLS\",\"SSL\"]', '', '', ''),
(17, 'mail_from', 'email', 'Mail from', '', 'string', '', '10000@qq.com', '', '', '', ''),
(18, 'attachmentcategory', 'dictionary', 'Attachment category', '', 'array', '', '{\"category1\":\"Category1\",\"category2\":\"Category2\",\"custom\":\"Custom\"}', '', '', '', '');

-- 用户表  只存用户登陆注册头像  基本信息 其他都用分表    跟业务相关的全部分表
DROP TABLE IF EXISTS `je_user`;
CREATE TABLE IF NOT EXISTS `je_user` (
	`id` 			int(11) unsigned NOT NULL AUTO_INCREMENT 			COMMENT 'ID',
 	`group_id` 		int(10) unsigned NOT NULL DEFAULT '0' 				COMMENT '角色组',
	`username` 		varchar(10) NOT NULL DEFAULT '' 					COMMENT '用户名',
	`nickname` 		varchar(10) NOT NULL DEFAULT '' 					COMMENT '昵称',
	`password`		char(32) NOT NULL DEFAULT '' 						COMMENT '密码',
	`salt` 			char(6) NOT NULL DEFAULT '' 						COMMENT '加密',
	`email` 		varchar(40) NOT NULL DEFAULT '' 					COMMENT '邮箱',
	`mobile` 		varchar(11) NOT NULL DEFAULT '' 					COMMENT '手机',
	`mobileswitch` 	tinyint(1) NOT NULL DEFAULT '0' 					COMMENT '手机激活:0=否,1=是',
	`emailswitch` 	tinyint(1) NOT NULL DEFAULT '0' 					COMMENT '邮箱激活:0=否,1=是',
	`avatar` 		varchar(80) NOT NULL DEFAULT ''						COMMENT '头像',
	`level` 		tinyint(1) unsigned NOT NULL DEFAULT '0' 			COMMENT '等级',
  	`gender` 		enum('0','1','2') DEFAULT '2' 						COMMENT '性别:0=女,1=男,2=未知',
	`birthday` 		date DEFAULT '0000-00-00' 									COMMENT '生日',
  	`bio` 			varchar(100) NOT NULL DEFAULT ''	 				COMMENT '格言',
	`money` 		decimal(10,2) NOT NULL DEFAULT '0.00' 				COMMENT '余额',
	`score` 		int(10) NOT NULL DEFAULT '0'						COMMENT '积分',
	`successions` 	int(10) unsigned NOT NULL DEFAULT '1' 				COMMENT '连续登录天数',
	`maxsuccessions`int(10) unsigned NOT NULL DEFAULT '1' 				COMMENT '最大连续登录天数',
  	`prevtime` 		int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '上次登录时间',
	`logintime` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '登录时间',
	`loginip` 		char(15) NOT NULL DEFAULT '' 						COMMENT '登录IP',
	`loginfailure` 	tinyint(1) unsigned NOT NULL DEFAULT '0' 			COMMENT '失败次数',
	`jointime` 		int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '注册时间',
	`joinip` 		char(15) NOT NULL DEFAULT '' 						COMMENT '加入IP',
	`createtime`	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '创建时间',
	`updatetime` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '更新时间',
  	`status` 		enum('normal','hidden') NOT NULL DEFAULT 'normal' 	COMMENT '状态',
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`username`),
	KEY `mobile` (`mobile`),
	KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='用户表';


DROP TABLE IF EXISTS `je_user_token`;
CREATE TABLE IF NOT EXISTS `je_user_token` (
	`token` 		char(40) NOT NULL DEFAULT '' COMMENT 'Token',
	`user_id` 		int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
	`createtime` 	int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
	`expiretime` 	int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '过期时间',
	PRIMARY KEY (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='会员Token表';

DROP TABLE IF EXISTS `je_user_rule`;
CREATE TABLE IF NOT EXISTS `je_user_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) DEFAULT '0' COMMENT '是否菜单',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员规则表' AUTO_INCREMENT=13 ;

INSERT INTO `je_user_rule` (`id`, `pid`, `name`, `title`, `remark`, `ismenu`, `createtime`, `updatetime`, `weigh`, `status`) VALUES
(1, 0, 'index', 'Frontend', '', 1, 1491635035, 1491635035, 1, 'normal'),
(2, 0, 'api', 'API Interface', '', 1, 1491635035, 1491635035, 2, 'normal'),
(3, 1, 'user', 'User Module', '', 1, 1491635035, 1491635035, 12, 'normal'),
(4, 2, 'user', 'User Module', '', 1, 1491635035, 1491635035, 11, 'normal'),
(5, 3, 'index/user/login', 'Login', '', 0, 1491635035, 1491635035, 5, 'normal'),
(6, 3, 'index/user/register', 'Register', '', 0, 1491635035, 1491635035, 7, 'normal'),
(7, 3, 'index/user/index', 'User Center', '', 0, 1491635035, 1491635035, 9, 'normal'),
(8, 3, 'index/user/profile', 'Profile', '', 0, 1491635035, 1491635035, 4, 'normal'),
(9, 4, 'api/user/login', 'Login', '', 0, 1491635035, 1491635035, 6, 'normal'),
(10, 4, 'api/user/register', 'Register', '', 0, 1491635035, 1491635035, 8, 'normal'),
(11, 4, 'api/user/index', 'User Center', '', 0, 1491635035, 1491635035, 10, 'normal'),
(12, 4, 'api/user/profile', 'Profile', '', 0, 1491635035, 1491635035, 3, 'normal');


DROP TABLE IF EXISTS `je_user_group`;
CREATE TABLE IF NOT EXISTS `je_user_group` (
  `id` 			int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` 		varchar(50) NOT NULL DEFAULT '' COMMENT '组名',
  `rules` 		text COMMENT '权限节点',
  `createtime` 	int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '添加时间',
  `updatetime` 	int(11) unsigned NOT NULL DEFAULT '0'  COMMENT '更新时间',
  `status` 		enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 COMMENT='会员组表';
INSERT INTO `je_user_group` (`id`, `name`, `rules`, `createtime`, `updatetime`, `status`) VALUES
(1, '默认组', '1,2,3,4,5,6,7,8,9,10,11,12', 1491635035, 1491635035, 'normal');

DROP TABLE IF EXISTS `je_user_money_log`;
CREATE TABLE IF NOT EXISTS `je_user_money_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更余额',
  `before` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更前余额',
  `after` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '变更后余额',
  `memo` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员余额变动表' AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `je_user_score_log`;
CREATE TABLE IF NOT EXISTS `je_user_score_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '变更积分',
  `before` int(10) NOT NULL DEFAULT '0' COMMENT '变更前积分',
  `after` int(10) NOT NULL DEFAULT '0' COMMENT '变更后积分',
  `memo` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员积分变动表' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `je_captcha`;
CREATE TABLE IF NOT EXISTS `je_captcha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` enum('moblie','email','site') NOT NULL DEFAULT  'site' COMMENT '类型',
  `event` enum('reg','login','update') NOT NULL DEFAULT 'reg' COMMENT '事件',
  `target` varchar(50) NOT NULL DEFAULT '' COMMENT '接收目标：手机|邮箱',
  `code` varchar(6) NOT NULL DEFAULT '' COMMENT '验证码',
  `times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'IP',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮箱验证码表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `je_version`;
CREATE TABLE IF NOT EXISTS `je_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `oldversion` varchar(30) NOT NULL DEFAULT '' COMMENT '旧版本号',
  `newversion` varchar(30) NOT NULL DEFAULT '' COMMENT '新版本号',
  `packagesize` varchar(30) NOT NULL DEFAULT '' COMMENT '包大小',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '升级内容',
  `downloadurl` varchar(255) NOT NULL DEFAULT '' COMMENT '下载地址',
  `enforce` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '强制更新',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `je_area`;
CREATE TABLE IF NOT EXISTS `je_area` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(10) DEFAULT '0' COMMENT '父id',
  `shortname` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `mergename` varchar(80) NOT NULL DEFAULT '' COMMENT '全称',
  `level` tinyint(4) DEFAULT '0' COMMENT '层级:1=省,2=市,3=区/县',
  `pinyin` varchar(50) NOT NULL DEFAULT '' COMMENT '拼音',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '长途区号',
  `zip` varchar(10) NOT NULL DEFAULT '' COMMENT '邮编',
  `first` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `lng` varchar(10) NOT NULL DEFAULT '' COMMENT '经度',
  `lat` varchar(10) NOT NULL DEFAULT '' COMMENT '纬度',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地区表' AUTO_INCREMENT=1 ;































DROP TABLE IF EXISTS `je_test`;
CREATE TABLE IF NOT EXISTS `je_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) DEFAULT '0' COMMENT '会员ID',
  `admin_id` int(10) DEFAULT '0' COMMENT '管理员ID',
  `category_id` int(10) unsigned DEFAULT '0' COMMENT '分类ID(单选)',
  `category_ids` varchar(100) NOT NULL DEFAULT '' COMMENT '分类ID(多选)',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT '标签',
  `week` enum('monday','tuesday','wednesday') NOT NULL DEFAULT 'monday' COMMENT '星期(单选):monday=星期一,tuesday=星期二,wednesday=星期三',
  `flag` set('hot','index','recommend') NOT NULL DEFAULT '' COMMENT '标志(多选):hot=热门,index=首页,recommend=推荐',
  `genderdata` enum('male','female') NOT NULL DEFAULT 'male' COMMENT '性别(单选):male=男,female=女',
  `hobbydata` set('music','reading','swimming') NOT NULL DEFAULT 'music' COMMENT '爱好(多选):music=音乐,reading=读书,swimming=游泳',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `images` varchar(1500) NOT NULL DEFAULT '' COMMENT '图片组',
  `attachfile` varchar(100) NOT NULL DEFAULT '' COMMENT '附件',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '省市',
  `json` varchar(255) NOT NULL DEFAULT '' COMMENT '配置:key=名称,value=值',
  `multiplejson` varchar(1500) NOT NULL DEFAULT '' COMMENT '二维数组:title=标题,intro=介绍,author=作者,age=年龄',
  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '价格',
  `views` int(10) unsigned DEFAULT '0' COMMENT '点击',
  `workrange` varchar(100) NOT NULL DEFAULT '' COMMENT '时间区间',
  `startdate` date DEFAULT '0000-00-00' COMMENT '开始日期',
  `activitytime` datetime DEFAULT '0000-00-00' COMMENT '活动时间(datetime)',
  `year` year(4) DEFAULT '0000' COMMENT '年',
  `times` time DEFAULT '00:00:00' COMMENT '时间',
  `refreshtime` int(10) DEFAULT '0' COMMENT '刷新时间(int)',
  `createtime` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) DEFAULT '0' COMMENT '更新时间',
  `deletetime` int(10) DEFAULT '0' COMMENT '删除时间',
  `weigh` int(10) DEFAULT '0' COMMENT '权重',
  `switch` tinyint(1) DEFAULT '0' COMMENT '开关',
  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',
  `state` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '状态值:0=禁用,1=正常,2=推荐',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='测试表' AUTO_INCREMENT=2 ;






















-- 用户表 {数据库结构以这里的为准  所有价格=*100  缓冲字段 uid,avatar,money,last_visit,last_ip,visit_count,status
DROP TABLE IF EXISTS `je_user`;
CREATE TABLE IF NOT EXISTS `je_user` (
	`uid` 			int(11) unsigned NOT NULL AUTO_INCREMENT 			COMMENT 'ID',
	`app_id` 		int(11) NOT NULL DEFAULT '0' 						COMMENT '应用id|来自注册应用',
	`user_name` 	varchar(10) NOT NULL DEFAULT '' 					COMMENT '用户名',
	`nickname` 		varchar(10) NOT NULL DEFAULT '' 					COMMENT '昵称',
	`email` 		varchar(40) NOT NULL DEFAULT '' 					COMMENT '邮箱',
	`email_switch` 	tinyint(1) NOT NULL DEFAULT '0' 					COMMENT '邮箱激活:0=否,1=是',
	`password`		char(32) NOT NULL DEFAULT '' 						COMMENT '密码',
	`salt` 			char(6) NOT NULL DEFAULT '' 						COMMENT '加密',
	`avatar` 		varchar(80) NOT NULL DEFAULT ''						COMMENT '头像',
	`phone` 		varchar(20) NOT NULL DEFAULT '' 					COMMENT '手机',
	`phone_switch` 	tinyint(1) NOT NULL DEFAULT '0' 					COMMENT '手机激活:0=否,1=是',
	`token` 		varchar(20) NOT NULL DEFAULT '' 					COMMENT '登陆令牌',
	`pid` 			int(11) unsigned NOT NULL DEFAULT '0' 	 			COMMENT '个人信息 对应je_personal_info',	
	`reg_ip` 		char(15) NOT NULL DEFAULT '' 						COMMENT '注册ip',
	`last_time` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '最后登陆时间',
	`last_ip` 		char(15) NOT NULL DEFAULT '' 						COMMENT '最后登陆IP',
	`money`			int(11) NOT NULL DEFAULT '0'						COMMENT '用户余额',	
	`rank_points`	int(11) unsigned NOT NULL DEFAULT '0'				COMMENT '等级积分|跟消费积分是分开的',
	`pay_points`	int(11) unsigned NOT NULL DEFAULT '0'				COMMENT '消费积分|跟等级积分是分开的',
	`parent_id` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '推荐人uid',	
	`visit_count` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '登陆统计',
	`digg_count` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '赞|缓冲',
	`friend_count` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '好友数量|缓冲',
	`follow_count` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '关注数量|缓冲',
	`fans_count` 	int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '粉丝数量	|缓冲',
	`collect_count` int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '收藏|缓冲',
	`message_count` int(11) unsigned NOT NULL DEFAULT '0' 				COMMENT '新私信|缓冲',
	`total_cost`	int(11) unsigned NOT NULL DEFAULT '0'				COMMENT '一共消费多少钱',	
	`updatetime` 	bigint(11) unsigned NOT NULL DEFAULT '0' 			COMMENT '注册时间',
	`createtime`	bigint(11) unsigned NOT NULL DEFAULT '0' 			COMMENT '注册时间',
	`status` 		enum('0','1') NOT NULL DEFAULT '0' 					COMMENT '状态:0=正常,1=锁定',
	PRIMARY KEY (`uid`),
	UNIQUE KEY `phone` (`phone`),
	KEY `user_name` (`user_name`),
	KEY `nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='用户表';
-- }


-- 个人信息  用户表来对应此表，可以多对一
DROP TABLE IF EXISTS `je_personal_info`;
CREATE TABLE IF NOT EXISTS `je_personal_info` (
	`pid` 			int(11) unsigned NOT NULL AUTO_INCREMENT 			COMMENT 'ID',
	`name` 			varchar(100) NOT NULL DEFAULT '' 					COMMENT '身份证上的名',
	`sex` 			tinyint(1) unsigned NOT NULL DEFAULT '0' 			COMMENT '性别:0=保密,1=男,2=女',
	`qq` 			varchar(20) NOT NULL DEFAULT '' 					COMMENT 'QQ',
	`weixin` 		varchar(50) NOT NULL DEFAULT '' 					COMMENT '微信',
	`addr` 			varchar(200) NOT NULL DEFAULT '' 					COMMENT '人在哪',
	`addr_mark` 	varchar(200) NOT NULL DEFAULT '' 					COMMENT '商圈',
	`company` 		varchar(200) NOT NULL DEFAULT '' 					COMMENT '公司',
	`id_card` 		varchar(18) NOT NULL DEFAULT '' 					COMMENT '身份证',
	`id_card_switch` tinyint(1) NOT NULL DEFAULT '0' 					COMMENT '身份证审核:0=待审核,1=已通过,2未通过',
	`note` 			varchar(200) NOT NULL DEFAULT '' 					COMMENT '备注',
	PRIMARY KEY (`pid`),
	KEY `id_card` (`id_card`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- 库结束
```

##数据库设计规范
 
	1、数据库命名规范
		英文(区分大小写)数字下划线'_'组成;命名简洁明确;多个单词用下划线'_'分隔;
		例如：user, stat, log, 也可以wifi_user, wifi_stat, wifi_log给数据库加个前缀;
		除非是备份数据库可以加0-9的自然数：user_db_20151210;
	 	
	2、数据库表名命名规范
		命名规范同库命名
		例如：user_login,  user_role, user_role_relation
		表前缀'user_'可以有效的把相同关系的表显示在一起;
	 	
	3、数据库表字段名命名规范
		命名规范同库命名,除了id外不用_分隔
		例如：user_group表字段 user_id, groupname, createtime;
		每个表中必须有自增主键,add_time(默认系统时间)
		表与表之间的相关联字段名称要求尽可能的相同;
 	
	4、数据库表字段类型规范
		用尽量少的存储空间来存数一个字段的数据;varchar在内存存取数据时有时会根据指定长度存取
		例如：能使用int就不要使用varchar、char,能用varchar(16)就不要使用varchar(256);
		IP地址最好使用int类型;
		固定长度的类型最好使用char,例如：邮编;
		能使用tinyint就不要使用smallint,int;
		最好给每个字段一个默认值,最好不能为null;
 	
	5、数据库表索引规范
		命名简洁明确,例如：user_login表user_name字段的索引应为user_name_index唯一索引;
		为每个表创建一个主键索引;
		为每个表创建合理的索引;
		建立复合索引请慎重;
	 	
	6、简单熟悉数据库范式
		第一范式(1NF)：字段值具有原子性,不能再分(所有关系型数据库系统都满足第一范式);
			例如：姓名字段,其中姓和名是一个整体,如果区分姓和名那么必须设立两个独立字段;
	 	
		第二范式(2NF)：一个表必须有主键,即每行数据都能被唯一的区分;
			备注：必须先满足第一范式;
	 	
		第三范式(3NF)：一个表中不能包涵其他相关表中非关键字段的信息,即数据表不能有沉余字段;
			备注：必须先满足第二范式;
	
		数据库的三范式简单说法：①字段不可分。②有主键，非主键字段依赖主键。③非主键字段不能互相依赖。
	
		备注：往往我们在设计表中不能遵守第三范式,因为合理的沉余字段将会给我们减少join的查询;


##数据库开发的三十六条军规

	核心军规
		尽量不在数据库做运算
		控制单表数据量 纯INT不超过10M条，含Char不超过5M条
		保持表身段苗条
		平衡范式和冗余
		拒绝大SQL，复杂事务，大批量任务
	
	字段类军规
		用好数值字段，尽量简化字段位数
		把字符转化为数字
		优先使用Enum或Set
		避免使用Null字段
		少用并拆封Text/Blob
		不在数据库中存图片
	
	索引类军规
		谨慎合理添加索引
		字符字段必须建立前缀索引?
		不在索引列做运算
		自增列或全局ID做InnoDB主键
		尽量不用外键
	
	SQL类军规
		SQL尽可能简单
		保持事务连接短小
		尽可能避免使用SP/Trigger/Function
		尽量不用Select *
		改写Or为IN()
		改写Or为Union
		避免负向查询和%前缀模糊查询
		Count不要使用在可Null的字段上面
		减少Count(*)
		Limit高效分页，SELECT * FROM message WHERE id > 9527 (or sub select) limit 10
		使用Union ALL 而不用Union
		分解链接，保证高并发
		Group By 去除排序
		同数据类型的列值比较
		Load Data导入数据，比Insert快20倍
		打散大批量更新，尽量凌晨操作
	
	约定类军规
		隔离线上线下
		禁止未经DBA认证的子查询
		永远不在程序段显式加锁
		统一字符集为UTF-8，统一命名规范   
         
##性能分析工具
	show profile;
	mysqlsla;
	mysqldumpslow;
	explain;
	show slow log;
	show processlist;


##用户表设计思路
	登陆注册最公用部分为用户表  将来用作其他应用登陆，做成像QQ一样统一登陆
	与应用功能相关的每一个单独设计
	如用户表分为登陆表，登陆记录表，用户资料表，积分表，与电商相关的积分表如果功能不匹配独立另外设计

##fastadmin数据库生成规则
## 根据字段类型
<table><thead><tr><th>类型</th><th>备注</th><th>类型说明</th></tr></thead><tbody><tr><td>int</td><td>整型</td><td>自动生成type为number的文本框，步长为1</td></tr><tr><td>enum</td><td>枚举型</td><td>自动生成单选下拉列表框</td></tr><tr><td>set</td><td>set型</td><td>自动生成多选下拉列表框</td></tr><tr><td>float</td><td>浮点型</td><td>自动生成type为number的文本框，步长根据小数点位数生成</td></tr><tr><td>text</td><td>文本型</td><td>自动生成textarea文本框</td></tr><tr><td>datetime</td><td>日期时间</td><td>自动生成日期时间的组件</td></tr><tr><td>date</td><td>日期型</td><td>自动生成日期型的组件</td></tr><tr><td>timestamp</td><td>时间戳</td><td>自动生成日期时间的组件</td></tr></tbody></table>

## 特殊字段
<table><thead><tr><th>字段</th><th>字段名称</th><th>字段类型</th><th>字段说明</th></tr></thead><tbody><tr><td>user_id</td><td>会员ID</td><td>int</td><td>将生成选择会员的SelectPage组件，单选</td></tr><tr><td>user_ids</td><td>会员ID集合</td><td>varchar</td><td>将生成选择会员的SelectPage组件，多选</td></tr><tr><td>admin_id</td><td>管理员ID</td><td>int</td><td>将生成选择管理员的SelectPage组件</td></tr><tr><td>admin_ids</td><td>管理员ID集合</td><td>varchar</td><td>将生成选择管理员的SelectPage组件，多选</td></tr><tr><td>category_id</td><td>分类ID</td><td>int</td><td>将生成选择分类的下拉框，分类类型根据去掉前缀的表名，单选</td></tr><tr><td>category_ids</td><td>分类ID集合</td><td>varchar</td><td>将生成选择分类的下拉框，分类类型根据去掉前缀的表名，多选</td></tr><tr><td>weigh</td><td>权重</td><td>int</td><td>后台的排序字段，如果存在该字段将出现排序按钮，可上下拖动进行排序</td></tr><tr><td>createtime</td><td>创建时间</td><td>int</td><td>记录添加时间字段，不需要手动维护</td></tr><tr><td>updatetime</td><td>更新时间</td><td>int</td><td>记录更新时间的字段，不需要手动维护</td></tr><tr><td>deletetime</td><td>删除时间</td><td>int</td><td>记录删除时间的字段，不需要手动维护，如果存在此字段将会生成回收站功能，字段默认值务必为null</td></tr><tr><td>status</td><td>状态字段</td><td>enum</td><td>列表筛选字段，如果存在此字段将启用TAB选项卡展示列表</td></tr></tbody></table>

## 以特殊字符结尾的规则
<table><thead><tr><th>结尾字符</th><th>示例</th><th>类型要求</th><th>字段说明</th></tr></thead><tbody><tr><td>time</td><td>refreshtime</td><td>int/timestamp/datetime</td><td>识别为日期时间型数据，自动创建选择时间的组件</td></tr><tr><td>image</td><td>smallimage</td><td>varchar</td><td>识别为图片文件，自动生成可上传图片的组件，单图</td></tr><tr><td>images</td><td>smallimages</td><td>varchar</td><td>识别为图片文件，自动生成可上传图片的组件，多图</td></tr><tr><td>file</td><td>attachfile</td><td>varchar</td><td>识别为普通文件，自动生成可上传文件的组件，单文件</td></tr><tr><td>files</td><td>attachfiles</td><td>varchar</td><td>识别为普通文件，自动生成可上传文件的组件，多文件</td></tr><tr><td>avatar</td><td>miniavatar</td><td>varchar</td><td>识别为头像，自动生成可上传图片的组件，单图</td></tr><tr><td>avatars</td><td>miniavatars</td><td>varchar</td><td>识别为头像，自动生成可上传图片的组件，多图</td></tr><tr><td>content</td><td>maincontent</td><td>text/mediumtext/bigtext</td><td>识别为内容，自动生成富文本编辑器(需安装富文本插件)</td></tr><tr><td>_id</td><td>user_id</td><td>int/varchar</td><td>识别为关联字段，自动生成可自动完成的文本框，单选</td></tr><tr><td>_ids</td><td>user_ids</td><td>varchar</td><td>识别为关联字段，自动生成可自动完成的文本框，多选</td></tr><tr><td>list</td><td>timelist</td><td>enum</td><td>识别为列表字段，自动生成单选下拉列表</td></tr><tr><td>list</td><td>timelist</td><td>set</td><td>识别为列表字段，自动生成多选下拉列表</td></tr><tr><td>data</td><td>hobbydata</td><td>enum</td><td>识别为选项字段，自动生成单选框</td></tr><tr><td>data</td><td>hobbydata</td><td>set</td><td>识别为选项字段，自动生成复选框</td></tr><tr><td>json</td><td>configjson</td><td>varchar</td><td>识别为键值组件，自动生成键值录入组件</td></tr><tr><td>switch</td><td>siteswitch</td><td>tinyint</td><td>识别为开关字段，自动生成开关组件</td></tr><tr><td>range</td><td>daterange</td><td>varchar</td><td>识别为时间区间组件，自动生成时间区间组件，仅支持1.3.0+</td></tr><tr><td>tag</td><td>articletag</td><td>varchar</td><td>识别为Tagsinput，自动生成标签输入组件，仅支持1.3.0+</td></tr><tr><td>tags</td><td>articletags</td><td>varchar</td><td>识别为Tagsinput，自动生成标签输入组件，仅支持1.3.0+</td></tr></tbody></table>> 温馨提示：以list或data结尾的字段必须搭配enum或set类型才起作用

## 注释说明
<table><thead><tr><th>字段</th><th>注释内容</th><th>字段类型</th><th>字段说明</th></tr></thead><tbody><tr><td>status</td><td>状态</td><td>int</td><td>将生成普通语言包和普通文本框</td></tr><tr><td>status</td><td>状态</td><td>enum(‘0’,’1’,’2’)</td><td>将生成普通语言包和单选下拉列表，同时生成TAB选项卡</td></tr><tr><td>status</td><td>状态:0=隐藏,1=正常,2=推荐</td><td>enum(‘0’,’1’,’2’)</td><td>将生成多个语言包和单选下拉列表，同时生成TAB选项卡,且列表中的值显示为对应的文字##</td></tr></tbody></table>	

