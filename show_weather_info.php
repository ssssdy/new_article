<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="./lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <title> 文章管理系统主页 </title>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">文章系统</a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">下拉菜单<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">jmeter</a></li>
                        <li><a href="#">EJB</a></li>
                        <li><a href="#">Jasper Report</a></li>
                        <li class="divider"></li>
                        <li><a href="#">分离的链接</a></li>
                        <li class="divider"></li>
                        <li><a href="#">另一个分离的链接</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                require './helpers/global_helper.php';
                require './model/news_model.class.php';
                require './model/user_model.class.php';
                require './model/tag_model.class.php';
//                require './cache/base_cache.class.php';
                require './cache/weather_cache.php';
                check_login();
                ?>
            </ul>
        </div>
    </div>
</nav
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_VISITOR:
                    break;
                case ROLE_TYPE_EDITOR:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                    break;
            }
            ?>
        </div>
        <div class="col-md-5">
            <?php
            $weather_cache = new Weather_cache();
            $city_id = $weather_cache->get('now_city_id');
            dump($city_id);
            $today_weather_info =$weather_cache->get_weather_info_from_cache($city_id);
            if ($today_weather_info == null) {
                $today_weather_info = get_weather_info_from_new($city_id);
                echo "从ＡＰＩ获取";
            } else {
                echo "从缓存获取";
            }
            ?>
            <div class="container-fluid">
                <form action="action.php?action=switch_city" method="post">
                    <input type="text" name="city_name" placeholder="请输入您要查找的城市名"/>
                    <input type="submit" value="切换城市"/>
                </form>
                <br/>
                <ul class="nav nav-pills nav-stacked">
                    <li><p><strong><?= $today_weather_info['aqiDetail']['area'] ?></strong>(今天)</p></li>
                    <li>
                        <span><?= $today_weather_info['weather'] ?></span>
                        <span><?php echo "<img width='60' height='50' src='" . $today_weather_info['weather_pic'] . "'/>"; ?></span>
                    </li>
                    <li>空气质量:<?= $today_weather_info['aqiDetail']['quality'] ?></li>
                    <li>当前气温:<?= $today_weather_info['temperature'] ?>
                        (<?= $today_weather_info['temperature_time'] ?>)
                    </li>
                    <li><b>风向:</b><i><?= $today_weather_info['wind_direction'] ?></i></li>
                    <li><b>风力:</b><i><?= $today_weather_info['wind_power'] ?></i></li>
                    <li>PM2.5: <?= $today_weather_info['aqiDetail']['pm2_5']; ?></li>
                </ul>
            </div>
            <br/>
            <hr width="100%"/>
        </div>
    </div>
</div>
</body>
</html>