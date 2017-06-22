<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="./static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title> 文章管理系统主页 </title>
</head>
<body>
<div>
    <div class="login">
        <?php
        require './helpers/global_helper.php';
        require './cache/base_cache.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_type']) {
            case ROLE_TYPE_VISITOR:
                break;
            case ROLE_TYPE_EDITOR:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <h3 align="center" style="font-size: 26px">实时天气</h3>
        <?php
        $redis = new Base_Cache();
        if (($redis->is_exists('now_city_id')) == 0) {
            $today_weather_info = get_weather_info_from_new();
        }
        $city_id = $redis->get('now_city_id');
        $today_weather_info = get_weather_info_from_cache($city_id);
//        dump($today_weather_info);
        ?>
        <div>
            <div>
                <form style="text-align: center" action="action.php?action=switch_city" method="post">
                    <input type="text" name="city_name" placeholder="请输入您要查找的城市名"/>
                    <input type="submit" value="切换城市"/>
                </form>
                <ul>
                    <li><p><strong><?= $today_weather_info['aqiDetail']['area'] ?></strong>(今天)</p></li>
                    <li>
                        <span><?= $today_weather_info['weather'] ?></span>
                        <span><?php echo "<img width='60' height='50' src='" . $today_weather_info['weather_pic'] . "'/>"; ?></span>
                    </li>
                    <li>空气质量:<?= $today_weather_info['aqiDetail']['quality'] ?></li>
                    <li>当前气温:<?= $today_weather_info['temperature'] ?>(<?= $today_weather_info['temperature_time'] ?>)
                    </li>
                    <li><b>风向:</b><i><?= $today_weather_info['wind_direction'] ?></i></li>
                    <li><b>风力:</b><i><?= $today_weather_info['wind_power'] ?></i></li>
                    <li>PM2.5: <?= $today_weather_info['aqiDetail']['pm2_5']; ?></li>
                </ul>
            </div>
        </div>
        <br/>
        <hr width="100%"/>
    </div>
</div>
</body>
</html>