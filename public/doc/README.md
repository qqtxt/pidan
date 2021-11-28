<p align=center>
  <a href="http://www.layui.com">
    <img src="./logo.png" alt="layui" width="360">
  </a>
</p>
<p align=center>
 用layuiadmin打造thinkphp5.1.41后台
</p>

<p align="center">
  <a href="https://travis-ci.org/sentsin/layui"><img alt="Build Status" src="https://img.shields.io/travis/sentsin/layui/master.svg"></a>
    <a href="https://coveralls.io/r/sentsin/layui?branch=master"><img alt="Test Coverage" src="https://img.shields.io/coveralls/sentsin/layui/master.svg"></a>
</p>


# 编码规则


## 数据库设计规则
* 主键统一用id,主键作为关联ID时用[表名]+[_id],如:user表主键id,user_group表关联用户id为 user_id,方便框架附加一些功能  
* ***表名可以用下划线分隔如：user_group，字段名不用如username,字段只有关联字段用下划线连接，如category_id,category_name***
* 字段的注释会转为中文语言包，但|后的内容忽略

当按如下的规则进行字段命名、类型设置和备注时  
使用php think crud -t 表名生成CRUD时会自动生成对应的HTML元素和组件  

### 根据字段类型
类型 | 备注 | 类型说明
---- | ---- | -----
int | 整型 | 自动生成type为number的文本框，步长为1
enum | 枚举型 | 自动生成单选下拉列表框
set | set型 | 自动生成多选下拉列表框
float | 浮点型 | 自动生成type为number的文本框，步长根据小数点位数生成
text | 文本型 | 自动生成textarea文本框
datetime | 日期时间 | 自动生成日期时间的组件
date | 日期型 | 自动生成日期型的组件
timestamp | 时间戳 | 自动生成日期时间的组件

### 特殊字段
字段 | 字段名称 | 字段类型 | 字段说明
---- | ---- | ----- | -----
category_id | 分类ID | int | 将生成选择分类的下拉框,分类类型根据去掉前缀的表名，单选
category_ids | 多选分类ID | varchar | 将生成选择分类的下拉框,分类类型根据去掉前缀的表名，多选
weigh | 权重 | int | 后台的排序字段，如果存在该字段将出现排序按钮，可上下拖动进行排序
createtime | 创建时间 | int | 记录添加时间字段,不需要手动维护
updatetime | 更新时间 | int | 记录更新时间的字段,不需要手动维护
deletetime | 删除时间 | int | 记录删除时间的字段,不需要手动维护,如果存在此字段将会生成回收站功能,字段默认值务必为null
status | 状态字段 | enum | 列表筛选字段,如果存在此字段将启用TAB选项卡展示列表

### 以特殊字符结尾的规则
结尾字符 | 示例 | 类型要求 | 字段说明
---- | ---- | ----- | -----
time | refreshtime | int | 识别为日期时间型数据，自动创建选择时间的组件
image | smallimage | varchar | 识别为图片文件，自动生成可上传图片的组件,单图
images | smallimages | varchar | 识别为图片文件，自动生成可上传图片的组件,多图
file | attachfile | varchar | 识别为普通文件，自动生成可上传文件的组件,单文件
files | attachfiles | varchar | 识别为普通文件，自动生成可上传文件的组件,多文件
avatar | miniavatar | varchar | 识别为头像，自动生成可上传图片的组件,单图
avatars | miniavatars | varchar | 识别为头像，自动生成可上传图片的组件,多图
content | maincontent | text | 识别为内容，自动生成富文本编辑器(需安装富文本插件)
_id | user_id | int/varchar | 识别为关联字段，自动生成可自动完成的文本框，单选
_ids | user_ids | varchar | 识别为关联字段，自动生成可自动完成的文本框，多选
list | timelist | enum | 识别为列表字段，自动生成单选下拉列表
list | timelist | set | 识别为列表字段，自动生成多选下拉列表
data | hobbydata | enum | 识别为选项字段，自动生成单选框
data | hobbydata | set | 识别为选项字段，自动生成复选框
json | configjson | varchar | 识别为键值组件，自动生成键值录入组件
switch | siteswitch | tinyint | 识别为开关字段，自动生成开关组件

### 注释说明
字段 | 注释内容 | 字段类型 | 字段说明
---- | ---- | ----- | -----
status | 状态 | int | 将生成普通语言包和普通文本框
status | 状态 | enum(‘0’,’1’,’2’) | 将生成普通语言包和单选下拉列表,同时生成TAB选项卡
status | 状态:0=隐藏,1=正常,2=推荐 | enum(‘0’,’1’,’2’) | 将生成多个语言包和单选下拉列表,同时生成TAB选项卡,且列表中的值显示为对应的文字##

### 表设计参考
```
DROP TABLE IF EXISTS `yl_test`;
CREATE TABLE `yl_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID(单选)',
  `category_ids` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类ID(多选)',
  `week` enum('monday','tuesday','wednesday') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '星期(单选):monday=星期一,tuesday=星期二,wednesday=星期三',
  `flag` set('hot','index','recommend') COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标志(多选):hot=热门,index=首页,recommend=推荐',
  `genderdata` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male' COMMENT '性别(单选):male=男,female=女',
  `hobbydata` set('music','reading','swimming') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '爱好(多选):music=音乐,reading=读书,swimming=游泳',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片',
  `images` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片组',
  `attachfile` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '附件',
  `keywords` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '省市',
  `json` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '配置:key=名称,value=值',
  `price` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击',
  `startdate` date DEFAULT NULL COMMENT '开始日期',
  `activitytime` datetime DEFAULT NULL COMMENT '活动时间(datetime)',
  `year` year(4) DEFAULT NULL COMMENT '年',
  `times` time DEFAULT NULL COMMENT '时间',
  `refreshtime` int(10) DEFAULT NULL COMMENT '刷新时间(int)',
  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开关',
  `status` enum('normal','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '状态 normal=正常,hidden=隐藏',
  `state` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态值:0=禁用,1=正常,2=推荐',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='测试表';
INSERT INTO `yl_test` VALUES (1,0,12,'12,13','monday','hot,index','male','music,reading','我是一篇测试文章','<p>我是测试内容</p>','/assets/img/avatar.png','/assets/img/avatar.png,/assets/img/qrcode.png','/assets/img/avatar.png','关键字','描述','广西壮族自治区/百色市/平果县','{\"a\":\"1\",\"b\":\"2\"}',0.00,0,'2017-07-10','2017-07-10 18:24:45',2017,'18:24:45',1491635035,1491635035,1491635035,NULL,0,1,'normal','1');
```



## AUTH权限认证系统说明
1.TP框架中已经内置了auth权限类，该类位于:  
/ThinkPHP/Library/Think/Auth.class.php  
2.执行该文件注释的sql语句生成3张表  
```

-- 与think3.2.3一致 fastadmin都在用的 auth权限系统三个表
DROP TABLE IF EXISTS `yl_auth_rule`;
CREATE TABLE `yl_auth_rule` (  
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  
    `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
    `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',  
    `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '',   
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用', 
    `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则附件条件,满足附加条件的规则,才认为是有效的规则', 
    PRIMARY KEY (`id`),  
    UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='项目方后台-公共-auth权限规则表';

DROP TABLE IF EXISTS `yl_auth_group`;
CREATE TABLE `yl_auth_group` ( 
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, 
    `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
    `rules` char(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户组表';

DROP TABLE IF EXISTS `yl_auth_group_access`;
CREATE TABLE `yl_auth_group_access` (  
    `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id';
    `group_id` mediumint(8) unsigned NOT NULL  COMMENT '用户组';
    UNIQUE KEY `uid_group_id` (`uid`,`group_id`),  
    KEY `uid` (`uid`), 
    KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='用户组明细表';
```
3.数据表关系
注：需要一张后台管理员表。如需其他表名，需在配置项中说明。  
<img src=0.png /><br><br>
  
<img src=1.png /><br><br>
  
<img src=2.png /><br><br>
  
<img src=3.png /><br><br>

4.实现权限验证
在后台公共控制器中，进行权限验证。
```
$auth=new \Think\Auth();//实例化auth类
$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_ NAME;//定义规则
$result=$auth->check($rule_name,$_SESSION['user']['id']);
//检查权限，通过验证返回true;失败返回false
if(!$result){ $this->error('您木有权限访问！！！再点打你丫的~');}
```


## php编码规则

1.类文件都是以.class.php为后缀，使用驼峰法命名，并且首字母大写，例如DbMysql.class.php  
2.类名和文件名一致（大小写也一致），例如 UserAction类的文件命名是UserAction.class.php  
3.函数及变量的命名使用小写字母和下划线的方式，例如 get_client_ip；  
4.表名和字段采用小写加下划线方式命名，例如 think_user，字段名不要以下划线开头，类似 _username 这样的数据表字段可能会被过滤。  
5.整站默认UTF-8编码无BOM  
6.每个缩进的单位约定是一个Tab(禁止设置为空格替代，Tab宽度应表示为4个空白字符宽度)，需每个参与项目的开发人员在编辑器(UltraEdit、EditPlus、ZendStudio等)中进行强制设定，以防在编写代码时遗忘而造成格式上的不规范。  
7.项目中使用Unix风格的换行符，即只有换行( LF 或 "\n" )没有回车( CR 或 "\r" )，请在你的编辑器内调整  


## js编码规则
1.类使用驼峰法命名，并且首字母大写  
2.函数及变量的命名使用小写字母和下划线的方式  统一为php格式好前后端对应找东西方便  
3.所有的js处理都定义在Jetee类中处理  
4.变量最好要用var let等声明，防作用域外泄

## css编码规则
1.规范按bootstrap  
2.所有本站类与ID命名都加个前缀j_，免冲突, 用小写字母和下划线的方式

## 目录设置
  我的理解 项目比分组更好移植 但分组更适合共享数据与函数，更方便   项目不支持子域名  
  JETEE框架系统和APP项目可以放到非WEB访问目录下面，根下只放用户上传及入口文件，从而提高网站的安全性。   
```
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─config             应用配置目录（同全局配置目录 可同时配置）
│  ├─module_name        模块目录
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  ├─config          配置目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行定义文件
│  ├─common.php         公共函数文件
│  └─tags.php           应用行为扩展定义文件
│
├─config                全局配置目录
│  ├─module_name        模块配置目录
│  │  ├─database.php    数据库配置
│  │  ├─cache           缓存配置
│  │  └─ ...            
│  │
│  ├─app.php            应用配置
│  ├─cache.php          缓存配置
│  ├─cookie.php         Cookie配置
│  ├─database.php       数据库配置
│  ├─log.php            日志配置
│  ├─session.php        Session配置
│  ├─template.php       模板引擎配置
│  └─trace.php          Trace配置
│
├─public                WEB目录（对外访问目录）
│  ├─static          	网站公共资源目录
│  │  ├─database.php    数据库配置
│  │  ├─cache           缓存配置
│  │  └─ ...            
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
```



## 快速上手

获得 layui 后，将其完整地部署到你的项目目录（或静态资源服务器），你只需要引入下述两个文件：

## [阅读文档](http://www.layui.com/)
从现在开始，尽情地拥抱 layui 吧！但愿她能成为你长远的开发伴侣，化作你方寸屏幕前的亿万字节！

## 相关
[官网](http://www.layui.com/)、[更新日志](http://www.layui.com/doc/base/changelog.html)、[社区交流](http://fly.layui.com)




# 库设计   

以实际库为准,这里为辅,主要方便设计

### 总后台
```

```
### 项目方
```

```
### 广告商
```

```
### 店铺
```

```