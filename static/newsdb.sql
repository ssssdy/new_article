-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-06-25 22:49:21
-- 服务器版本： 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsdb`
--

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `keywords` varchar(64) NOT NULL,
  `author` varchar(16) NOT NULL,
  `add_time` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `num_of_zan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `tag_id`, `title`, `keywords`, `author`, `add_time`, `content`, `image_url`, `num_of_zan`) VALUES
(43, 18, '经纪人告知乔治将离队让步行者感到惊讶', 'NBA', '方正', 1497098845, '<p style="margin-top: 0px; margin-bottom: 20px; padding: 0px; color: rgb(26, 41, 57); font-family: " lucida="" white-space:="" background-color:="">虎扑6月19日讯&nbsp;根据今日雅虎体育The Vertical记者Adrian Wojnarowski的报道，步行者当家球星保罗-乔治方面已经通知球队，他将在明年夏天成为自由球员，并且离开球队。根据《印第安纳波利斯星报》记者Nate Taylor的报道，一位了解情况的消息人士透露，乔治的经纪人Aaron Mintz昨日告知了步行者新任篮球运营总裁凯文-普里查德他们的计划.</p>', 'nba1.jpg', 0),
(52, 18, '小牛已经在内部商讨过交易卢比奥的事情', '小牛', '方正', 1497318012, '<p style="margin-top: 0px; margin-bottom: 20px; padding: 0px; color: rgb(26, 41, 57); font-family: " lucida="" white-space:="" background-color:="">虎扑6月19日讯&nbsp;根据Dallasbasketball.com记者Mike Fisher的报道，小牛已经在内部商讨过交易里基-卢比奥的事情，并且他们也商讨过在今年的选秀大会上选走法国控卫弗朗克-尼利基纳的事情。根据之前报道，森林狼有意签下德里克-罗斯，后者曾为他们的现任主教练汤姆-锡伯杜效过力。2016-17赛季常规赛，卢比奥场均出战32.9分钟，能够得到11.1分4.1篮板9.1助攻1.71抢断。根据之前的报道，小牛团队去欧洲考察了尼利基纳，尼利基纳来自法国，出生于1998年7月28日，身高1.96米，体重82公斤，可以打得分后卫和控球后卫两个位置。他本赛季在法国的Strasbourg IG俱乐部场均出战18.1分钟，可以拿到5.8分1.6助攻2篮板。</p><p><br/></p>', 'nba2.jpg', 0),
(69, 2, '美军舰与菲商船相撞:７名美军已死亡', '相撞', '方正', 1497767608, '<p><span id="_baidu_bookmark_start_1" style="display: none; line-height: 0px;">‍</span><span id="_baidu_bookmark_start_3" style="display: none; line-height: 0px;">‍</span>17日，美国海军公布了受损的“菲茨杰拉德”号驱逐舰被拖船拖回驻地——日本神奈川县横须贺海军基地的画面。美国海军上将约瑟夫·奥库安接受采访时说，目前美国、日本的军舰和飞机正在全力搜救失踪的七名船员。据他介绍，“菲茨杰拉德”号驱逐舰的右侧部分受损严重，海水已经灌进船员舱和舰体的其他区域。<span id="_baidu_bookmark_end_4" style="display: none; line-height: 0px;">‍</span><span id="_baidu_bookmark_end_2" style="display: none; line-height: 0px;">‍</span></p>', 'news1.jpg', 0),
(74, 2, '习近平向2017金砖国家运动会致贺信', '习近平', '方正', 1497838799, '<p style="margin-top: 28px; margin-bottom: 0px; padding: 0px; font-size: 16px; text-indent: 2em; font-stretch: normal; line-height: 28px; font-family: " microsoft="" color:="" text-align:="" white-space:="" background-color:="">新华社广州6月17日电2017年金砖国家运动会于6月17日晚在广州开幕。国家主席习近平致贺信，对运动会的召开表示热烈祝贺，向参加运动会的各国嘉宾、运动员、教练员们致以诚挚的欢迎。<span style="text-indent: 2em;">习近平指出，我们期待着以今年9月举行的金砖国家领导人厦门会议为契机，推动金砖国家人文交流合作取得新成果，为金砖国家合作夯实民意基础。</span><span style="text-indent: 2em;">习近平强调，金砖国家体育事业发展各具特色。本届运动会将为提高运动员竞技水平、普及传统体育项目、推动体育事业发展、促进人民友谊发挥积极作用。希望运动员们发扬风格、赛出水平、创造佳绩</span></p><p><br/></p>', '习近平.jpg', 0),
(75, 18, '史蒂夫-科尔：祝所有的爸爸们父亲节快乐', '科尔', '方正', 1497838998, '<p style="margin-top: 0px; margin-bottom: 20px; padding: 0px; color: rgb(26, 41, 57); font-family: " lucida="" white-space:="" background-color:="">虎扑6月19日讯&nbsp;今天，勇士主帅史蒂夫-科尔更新了自己的推特，祝各位父亲节快乐。“祝各位爸爸们父亲节快乐，把爱和和平给每一个人。”科尔在推特上写道。勇士本赛季常规赛67胜15负，季后赛16胜1负夺冠.</p><p></p>', 'nba3.jpg', 0);

-- --------------------------------------------------------

--
-- 表的结构 `news_comment`
--

CREATE TABLE `news_comment` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `create_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `news_comment`
--

INSERT INTO `news_comment` (`id`, `news_id`, `user_id`, `user_name`, `comment`, `create_time`) VALUES
(100, 43, 12, 'root', 'ff', '2017-06-25 20:10:07'),
(101, 43, 12, 'root', 'ffdf', '2017-06-25 20:10:09'),
(102, 43, 12, 'root', 'ffdffff', '2017-06-25 20:10:11'),
(103, 43, 12, 'root', 'ffdfffffff', '2017-06-25 20:10:13'),
(104, 43, 12, 'root', 'sss', '2017-06-25 20:47:58'),
(105, 43, 12, 'root', 'ffs', '2017-06-25 21:14:14'),
(106, 43, 12, 'root', 'dd', '2017-06-25 21:18:29'),
(107, 43, 12, 'root', 'sfsf', '2017-06-25 21:18:34'),
(108, 43, 12, 'root', '撒大大', '2017-06-25 22:22:11'),
(109, 43, 12, 'root', '撒大大的', '2017-06-25 22:22:14');

-- --------------------------------------------------------

--
-- 表的结构 `real_news`
--

CREATE TABLE `real_news` (
  `id` int(20) NOT NULL,
  `content` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `real_news`
--

INSERT INTO `real_news` (`id`, `content`) VALUES
(221, '<h3><a href="http://hb.qq.com/a/20170621/002721.htm"style="color:#DD0000">注意！学校周边现“牙签弩”</a></h3>'),
(222, '<h3> <a  href="http://hb.qq.com/a/20170621/007623.htm">武汉中考迷糊考生有百种</a></h3>'),
(223, '<h3> <a  href="http://hb.qq.com/a/20170621/007068.htm">水泥泵车司机违法施被刑拘</a></h3>'),
(224, '<h3><a href="/a/20170621/013680.htm">大树遮光家中发霉 高层居民不愿砍伐</a></h3>'),
(225, '<h3><a href="/a/20170621/006662.htm">中考作文写“一条小鱼” 考生有话说</a></h3>'),
(226, '<h3><a href="/a/20170621/006435.htm">武汉明天起机动车号牌新政正式实施</a></h3>'),
(227, '<h3><a href="/a/20170621/005696.htm">男子见“意中人” 接机的是三名大汉</a></h3>'),
(228, '<h3><a href="/a/20170621/002721.htm">学校周边现危险牙签弩 警方全面排查</a></h3>'),
(229, '<h3><a href="/a/20170620/032384.htm">小作坊发生爆炸 已确定一人死亡 </a></h3>'),
(230, '<h3><a href="/a/20170620/024367.htm">钓鱼人占桥垂钓 大水牛踩塌桥面被困</a></h3>');

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_type` int(10) NOT NULL,
  `role_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `role_type`, `role_name`) VALUES
(1, 2, '编辑'),
(2, 3, '管理员'),
(3, 4, '超级管理员'),
(4, 1, '游客');

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(1, '计算机'),
(2, '新闻'),
(3, '经济'),
(4, '哲学'),
(17, '数学'),
(18, 'NBA');

-- --------------------------------------------------------

--
-- 表的结构 `test`
--

CREATE TABLE `test` (
  `id` int(7) NOT NULL,
  `name` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `test`
--

INSERT INTO `test` (`id`, `name`) VALUES
(1, 'sven'),
(2, 'jim'),
(3, 'zhu'),
(4, 'wang'),
(5, 'ftd'),
(6, 'test'),
(7, 'test01'),
(8, 'test02'),
(9, 'test03');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role_type` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`, `phone`, `address`, `role_type`) VALUES
(10, '何彩云', '123', '159', '武汉', 3),
(12, 'root', '123', '158', '122', 4),
(24, '方正', '123', '15827398906', '武汉', 1),
(25, 'aaa', '123', '158', 'wuhan', 2),
(27, 'ccc', '123', '158', '广水', 3),
(28, 'ddd', '123', '158', 'ffff', 2),
(30, 'adf', '123', '111', '111', 3),
(31, 'gdg', '123', '123', '123', 3),
(32, 'dffs', '123', '123', '123', 2),
(33, 'kh', '123', '123', '132', 2),
(34, 'gs', '123', '123', '123', 3),
(35, 'dss', '123', '22', '11', 3),
(36, 'kkfjds', '123', '15827398906', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `zan_of_news`
--

CREATE TABLE `zan_of_news` (
  `id` int(11) NOT NULL,
  `news_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `zan_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zan_of_news`
--

INSERT INTO `zan_of_news` (`id`, `news_id`, `user_id`, `user_name`, `zan_time`) VALUES
(40, 43, 12, 'root', '2017-06-25 21:54:22'),
(41, 43, 12, 'root', '2017-06-25 21:54:24'),
(42, 43, 12, 'root', '2017-06-25 21:54:28'),
(43, 43, 12, 'root', '2017-06-25 21:57:59'),
(44, 43, 12, 'root', '2017-06-25 21:58:00'),
(45, 43, 12, 'root', '2017-06-25 22:13:47'),
(46, 43, 12, 'root', '2017-06-25 22:13:49'),
(47, 43, 12, 'root', '2017-06-25 22:13:50'),
(48, 43, 12, 'root', '2017-06-25 22:13:50'),
(49, 43, 12, 'root', '2017-06-25 22:14:10'),
(50, 43, 12, 'root', '2017-06-25 22:14:15'),
(51, 43, 12, 'root', '2017-06-25 22:14:22'),
(52, 43, 12, 'root', '2017-06-25 22:14:25'),
(53, 43, 12, 'root', '2017-06-25 22:14:27'),
(54, 43, 12, 'root', '2017-06-25 22:14:27'),
(55, 43, 12, 'root', '2017-06-25 22:14:27'),
(56, 43, 12, 'root', '2017-06-25 22:15:17'),
(57, 43, 12, 'root', '2017-06-25 22:15:18'),
(58, 43, 12, 'root', '2017-06-25 22:15:19'),
(59, 43, 12, 'root', '2017-06-25 22:15:19'),
(60, 43, 12, 'root', '2017-06-25 22:15:27'),
(61, 43, 12, 'root', '2017-06-25 22:15:44'),
(62, 43, 12, 'root', '2017-06-25 22:15:46'),
(63, 43, 12, 'root', '2017-06-25 22:15:47'),
(64, 43, 12, 'root', '2017-06-25 22:22:19'),
(65, 43, 12, 'root', '2017-06-25 22:22:20'),
(66, 43, 12, 'root', '2017-06-25 22:23:46'),
(67, 43, 12, 'root', '2017-06-25 22:23:48'),
(68, 43, 12, 'root', '2017-06-25 22:23:49'),
(69, 43, 12, 'root', '2017-06-25 22:23:49'),
(70, 43, 12, 'root', '2017-06-25 22:36:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_comment`
--
ALTER TABLE `news_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `real_news`
--
ALTER TABLE `real_news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `zan_of_news`
--
ALTER TABLE `zan_of_news`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- 使用表AUTO_INCREMENT `news_comment`
--
ALTER TABLE `news_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- 使用表AUTO_INCREMENT `real_news`
--
ALTER TABLE `real_news`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
--
-- 使用表AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `test`
--
ALTER TABLE `test`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- 使用表AUTO_INCREMENT `zan_of_news`
--
ALTER TABLE `zan_of_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
