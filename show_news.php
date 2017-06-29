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
                require './model/real_news_model.class.php';
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
        <div class="clearfix visible-xs"></div>
        <div class="col-md-10 table-responsive">
            <?php
            $real_news_model = new Real_News_Model();
            $redis = new Base_Cache();
            $data_status = $redis->is_exists('real_news');
            if ($data_status == 0) {
                $real_news_list_info = $real_news_model->get_real_time_news();
                $num = count($real_news_list_info);
                for ($i = 0; $i < $num; $i++) {
                    $redis->r_push('real_news', $real_news_list_info[$i]['content'], ONE_DAY);
                }
            }
            $list_length = $redis->list_length('real_news');
            echo "新闻总数量:" . $list_length . "<br>";
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page的值，假如不存在page，那么页数就是1
            $page_size = PAGE_SIZE;
            $page_num = ceil($list_length / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $real_news_info_redis = $redis->l_range('real_news', $offset, $page * $page_size - 1);
            echo "当页新闻数量:" . count($real_news_info_redis);
            echo "<ul class=\"nav nav-tabs nav-stacked\">";
            for ($i = 0; $i < count($real_news_info_redis); $i++) {
//                $real_news_info = json_decode($real_news_info_redis[$i],true);
                echo "<li>{$real_news_info_redis[$i]}</li>";
            }
            echo "</ul>";
            ?>
            <?php
            $prev = $page - 1;
            $next = $page + 1;
            echo "<br/>";
            echo "<div>共 " . $page_num . " 页 ";
            if ($page > 1) {
                echo "<a href='show_news.php?page=1'>首页 </a>";
                echo "<a href='show_news.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='show_news.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='show_news.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($j = 1; $j <= $page_num; $j++) {
                $show = ($j != $page) ? "<a href='show_news.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
                echo $show . "   ";
            }
            ?>
            <br/>
            <hr width="100%"/>
        </div>
    </div>
</div>
</body>
</html>