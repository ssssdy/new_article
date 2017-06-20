-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-06-12 10:23:31
-- 服务器版本： 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsdb`
--

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE `news` (
  `id`        INT(10) UNSIGNED NOT NULL,
  `tag_id`    INT(11)      DEFAULT NULL,
  `title`     VARCHAR(64)      NOT NULL,
  `keywords`  VARCHAR(64)      NOT NULL,
  `author`    VARCHAR(16)      NOT NULL,
  `addtime`   INT(10) UNSIGNED NOT NULL,
  `content`   TEXT             NOT NULL,
  `image_url` VARCHAR(100) DEFAULT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `tag_id`, `title`, `keywords`, `author`, `addtime`, `content`, `image_url`) VALUES
  (40, 2, '爱的', '是多大的', '硕大的', 1497062999, '<p>dfsdfdd</p><p>dsdfs&nbsp;</p>', '009.jpg'),
  (41, 2, '速度发发', '啊发发', '啊发发', 1497065305, '<p>发发发广告给</p>', '003.jpg'),
  (42, 1, '二十多岁多', '萨达', '硕大的', 1497098828, '<p>阿萨德撒多</p>', '006.jpg'),
  (43, 2, '是撒大多', '艾斯德斯', '爱仕达多', 1497098845, '<p>挨打的</p>', '003.jpg'),
  (47, 1, '水电费水电费', '都是', '算法', 1497150062, '<p>打发打发</p>', '008.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE `roles` (
  `id`        INT(10) UNSIGNED NOT NULL,
  `role_type` INT(10)          NOT NULL,
  `role_name` VARCHAR(30)      NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `role_type`, `role_name`) VALUES
  (1, 1, '编辑'),
  (2, 2, '管理员'),
  (3, 3, '超级管理员'),
  (4, 0, '游客');

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE `tag` (
  `tag_id`   INT(11)      NOT NULL,
  `tag_name` VARCHAR(100) NOT NULL
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
  (1, '计算机'),
  (2, '新闻'),
  (3, '经济'),
  (4, '哲学'),
  (8, '体育');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id`   INT(11)      NOT NULL,
  `user_name` VARCHAR(100) NOT NULL,
  `password`  VARCHAR(100) NOT NULL,
  `phone`     VARCHAR(100) DEFAULT NULL,
  `address`   VARCHAR(255) DEFAULT NULL,
  `role_type` INT(11)      DEFAULT '0'
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `phone`, `address`, `role_type`) VALUES
  (10, '何彩云', '123', '159', '武汉', 2),
  (12, 'root', '123', '158', '122', 3),
  (24, '方正', '123', '15827398906', '武汉', 2),
  (25, 'aaa', '123', '158', 'wuhan', 2),
  (26, 'bbb', '123', '158', '庙山', 2),
  (27, 'ccc', '123', '158', '广水', 2),
  (28, 'ddd', '123', '158', 'ffff', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `tag_id_2` (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 49;
--
-- 使用表AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 5;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 29;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
