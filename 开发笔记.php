开发笔记.php

库设计    一定先修改这里，以这里为基准    全部为降序
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
