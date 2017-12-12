-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-12 07:51:01
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pp`
--

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_group`
--

CREATE TABLE `dp_auth_group` (
`id` mediumint(8) UNSIGNED NOT NULL,
`title` char(100) NOT NULL DEFAULT '',
`status` tinyint(1) NOT NULL DEFAULT '1',
`rules` char(80) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `dp_auth_group`
--

INSERT INTO `dp_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '商品模块', 1, '9'),
(2, '订单模块', 1, '10'),
(3, '权限模块', 1, '11');

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_group_access`
--

CREATE TABLE `dp_auth_group_access` (
`uid` mediumint(8) UNSIGNED NOT NULL,
`group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `dp_auth_group_access`
--

INSERT INTO `dp_auth_group_access` (`uid`, `group_id`) VALUES
(2, 1),
(2, 2),
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_rule`
--

CREATE TABLE `dp_auth_rule` (
`id` mediumint(8) UNSIGNED NOT NULL,
`name` char(80) NOT NULL DEFAULT '',
`title` char(20) NOT NULL DEFAULT '',
`status` tinyint(1) NOT NULL DEFAULT '1',
`condition` char(100) NOT NULL DEFAULT '',
`rule` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `dp_auth_rule`
--

INSERT INTO `dp_auth_rule` (`id`, `name`, `title`, `status`, `condition`, `rule`) VALUES
(9, 'product/index', '商品管理', 1, '', 'product/*'),
(10, 'order/index', '订单模块', 1, '', 'order/*'),
(11, 'manage/member', '权限管理', 1, '', 'manage/*');

-- --------------------------------------------------------

--
-- 表的结构 `dp_node`
--

CREATE TABLE `dp_node` (
`nid` smallint(6) NOT NULL COMMENT '节点id',
`title` char(30) NOT NULL COMMENT '中文标题',
`control` char(30) NOT NULL COMMENT '控制器',
`method` char(30) NOT NULL COMMENT '方法',
`param` char(100) NOT NULL COMMENT '参数',
`comment` varchar(255) NOT NULL COMMENT '备注',
`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 显示 0 不显示',
`type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '类型 1 权限控制菜单 2 普通菜单',
`pid` smallint(6) NOT NULL DEFAULT '0' COMMENT '父id',
`order` smallint(6) NOT NULL DEFAULT '255' COMMENT '排序',
`role` smallint(6) NOT NULL,
`url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `dp_node`
--

INSERT INTO `dp_node` (`nid`, `title`, `control`, `method`, `param`, `comment`, `status`, `type`, `pid`, `order`, `role`, `url`) VALUES
(54, '商品管理', '', '', '', '', 1, 1, 0, 255, 9, ''),
(55, '商品列表', '', '', '', '', 1, 1, 54, 255, 0, 'product/index'),
(57, '订单模块', '', '', '', '', 1, 2, 0, 255, 10, ''),
(58, '订单列表', '', '', '', '', 1, 1, 57, 255, 0, 'order/index'),
(59, '系统管理', '', '', '', '', 1, 2, 0, 255, 11, ''),
(60, '用户管理', '', '', '', '', 1, 1, 59, 255, 0, 'manage/member'),
(61, '模块管理', '', '', '', '', 1, 1, 59, 255, 0, 'manage/group'),
(62, '规则管理', '', '', '', '', 1, 1, 59, 255, 0, 'manage/rule'),
(63, '菜单管理', '', '', '', '', 1, 2, 59, 255, 0, 'manage/menu');

-- --------------------------------------------------------

--
-- 表的结构 `dp_staff`
--

CREATE TABLE `dp_staff` (
`id` int(11) NOT NULL,
`username` varchar(32) NOT NULL,
`company` varchar(100) NOT NULL,
`email` varchar(100) NOT NULL,
`password` varchar(32) NOT NULL,
`status` tinyint(1) NOT NULL DEFAULT '1',
`addtime` datetime NOT NULL,
`level` tinyint(1) NOT NULL,
`phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `dp_staff`
--

INSERT INTO `dp_staff` (`id`, `username`, `company`, `email`, `password`, `status`, `addtime`, `level`, `phone`) VALUES
(1, 'admin', 'cc', '408178197@qq.com', '5d0dcfa9c8267b8242328723b02303b8', 1, '2017-07-20 16:41:48', 2, '13402051267');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
`id` int(11) NOT NULL,
`title` varchar(50) NOT NULL,
`product_ns` varchar(20) NOT NULL,
`price` decimal(8,2) NOT NULL DEFAULT '0.00',
`barcode` varchar(20) NOT NULL,
`status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `title`, `product_ns`, `price`, `barcode`, `status`) VALUES
(8, '111', '1', '1.00', '1', 1),
(2, 'asdf', 'asd', '1.00', 'asd', 1),
(4, 'safd', 'asdf', '1.00', 'asd', 1),
(5, 'safd', 'asdf', '100.00', 'asd', 1),
(6, 'safd', 'asdf', '1.00', 'asd', 1),
(7, 'safd', 'asdf', '1.00', 'asd', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dp_auth_group`
--
ALTER TABLE `dp_auth_group`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_auth_rule`
--
ALTER TABLE `dp_auth_rule`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_node`
--
ALTER TABLE `dp_node`
ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `dp_staff`
--
ALTER TABLE `dp_staff`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dp_auth_group`
--
ALTER TABLE `dp_auth_group`
MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `dp_auth_rule`
--
ALTER TABLE `dp_auth_rule`
MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `dp_node`
--
ALTER TABLE `dp_node`
MODIFY `nid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '节点id', AUTO_INCREMENT=65;
--
-- 使用表AUTO_INCREMENT `dp_staff`
--
ALTER TABLE `dp_staff`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
