<?php
require("dbconfig.php");
require './models/news_model.class.php';
require './models/tag_model.class.php';
require './models/user_model.class.php';
include("./helpers/global_helper.php");
$link = new News_Model();
$link1 = new User_Model();
$user_info = $link1->get_all_user_info();
dump($user_info);