<?php
require("dbconfig.php");
require 'news_model.class.php';
require 'tag_model.class.php';
require 'user_model.class.php';
include("globle_helper.php");
$link = new News_Model();
$link1 = new User_Model();
$user_info = $link1->get_AllUser_info();
dump($user_info);