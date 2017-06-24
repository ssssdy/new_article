<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="./lib/bootstrap_demo/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap_demo/dist/js/bootstrap.min.js"></script>
    <title> 文章管理系统 </title>
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
                require './cache/base_cache.class.php';
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
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a></li>>;
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-10 table-responsive">
            <?php
            $news_id = $_GET['id'];
            $news_model = new News_Model();
            $redis = new Base_Cache();
            $news_status = $redis->is_exists($news_id);
            if ($news_status == 0) {
                $news_info = $news_model->get_one_news_info($news_id);
                $redis->set($news_id, json_encode($news_info), SURVIVAL_TIME_OF_NEWS);
            }
            $news_info_redis = json_decode($redis->get($news_id), true);
            $rest_survival_time = $redis->rest_survival_time($news_id);
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div style="float: right" class="col-md-3">
                        <?php
                        echo "当前用户IP:" . $_SERVER['REMOTE_ADDR'] . "<br>";
                        foreach (RATE_LIMITING_ARR as $limit => $timeout) {
                            access_limit($_SERVER['REMOTE_ADDR'], $limit, $timeout);
                        }
                        echo "<br>";
                        echo "缓存状态:";
                        if ($news_status == 0) {
                            echo "先存后取" . "<br>";
                        } else {
                            echo "直接从缓存中读取" . "<br>";
                        }
                        echo "缓存有效期剩余:" . seconds_to_date($rest_survival_time) . "<br>";
                        //            echo "<button onclick='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</button>";
                        echo "<button><a href='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</a></button><br/>";
                        $count = $redis->increase_access_time($_SERVER['REMOTE_ADDR']);
                        echo $_SERVER['REMOTE_ADDR']."的访问次数:".$count."<br/>";
                        ?>经纪人告知乔治将离队让步行者感到惊讶

                    </div>
                    <div class="col-md-9">
                        <h2><b><span><?= $news_info_redis['title'] ?></span></b></h2>
                        <p style="font-size: 16px"><span>发布人:<?= $news_info_redis['author'] ?></span>&nbsp;
                            <span>发布时间:<?= date('Y-m-d', $news_info_redis['add_time']) ?></span>&nbsp;
                            <span>关键字：<span><?= $news_info_redis['keywords'] ?></span></span></p>
                        <?php echo "<td><img width='600' height='300' class='img-responsive' alt='响应式图像' src='" . qiniu_image_display($news_info_redis['image_url']) . "'/></td>"; ?>
                        <p style="font-size: 17px"><?= $news_info_redis['content'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function refresh_cache(key) {
                if (confirm("确定要刷新缓存吗？")) {
                    window.location = "action.php?action=refresh_cache&key=" + key;
                }
            }
        </script>
</body>
</html>