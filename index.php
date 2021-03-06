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
                        <li><a href="#">菜单一</a></li>
                        <li><a href="#">菜单二</a></li>
                        <li><a href="#">菜单三</a></li>
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
            <div class=" nav navbar-right">
                <a class="navbar-brand" href="show_weather_info.php">天气预报</a>
            </div>
            <div class=" nav navbar-right">
                <a class="navbar-brand" href="access_times_rank.php">IP访问排行榜</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_VISITOR:
                    break;
                case ROLE_TYPE_EDITOR:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='show_news.php'>实时新闻</a></li>;
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='show_news.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='show_news.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li>
                        </ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-10 table-responsive panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>文章id</th>
                        <th>文章类别</th>
                        <th>文章标题</th>
                        <th>发布时间</th>
                        <?php
                        if (isset($_SESSION['user_name']) && $_SESSION['role_type'] >= ROLE_TYPE_EDITOR) {
                            echo "<th>操作</th>";
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $news_model = new News_Model();
                    $redis = new Base_Cache();
                    $data_status = $redis->is_exists('news_list');
                    if ($data_status == 0) {
                        echo "数据库有数据修改" . "<br>";
                        $news_info_list = $news_model->get_all_news_info();
                        $num = count($news_info_list);
                        foreach ($news_info_list as $news_info) {
                            $redis->r_push('news_list', json_encode($news_info), ONE_DAY);
                        }
                    }
                    $list_length = $redis->list_length('news_list');
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
                    $page_size = PAGE_SIZE;
                    $page_num = ceil($list_length / $page_size);
                    if ($page > $page_num || $page == 0) {
                        echo "Error : Can Not Found The page .";
                        exit;
                    }
                    $offset = ($page - 1) * $page_size;
                    $news_info_list_redis = $redis->l_range('news_list', $offset, $page * $page_size - 1);
                    for ($i = 0; $i < count($news_info_list_redis); $i++) {
                        $news_info_redis = json_decode($news_info_list_redis[$i], true);
                        $tag_model = new Tag_Model();
                        $tag_info = $tag_model->get_one_tag_info($news_info_redis['tag_id']);
                        echo "<tr>";
                        echo "<td>{$news_info_redis['id']}</td>";
                        echo "<td>{$tag_info['tag_name']}</td>";
                        echo "<td><a href='article_details.php?id={$news_info_redis['id']}'>{$news_info_redis['title']}</a></td>";
                        echo "<td>" . date("Y-m-d", $news_info_redis['add_time']) . "</td>";
                        if ($_SESSION['role_type'] >= ROLE_TYPE_EDITOR) {
                            echo "<td>";
                            echo "<a href='edit_article.php?id={$news_info_redis['id']}'>编辑文章</a><br/>";
                            if ($_SESSION['role_type'] >= ROLE_TYPE_ADMIN) {
                                echo "<a href='javascript:delete_news({$news_info_redis['id']})'>删除文章</a>";
                            }
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            $prev = $page - 1;
            $next = $page + 1;
            echo "<br/>";
            echo "<div align='center'>共 " . $page_num . " 页 ";
            if ($page > 1) {
                echo "<a href='index.php?page=1'>首页 </a>";
                echo "<a href='index.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='index.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='index.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($j = 1; $j <= $page_num; $j++) {
                $show = ($j != $page) ? "<a href='index.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
                echo $show . "   ";
            }
            echo "</div>";
            ?>
            <hr width="100%"/>
        </div>
        <script type="text/javascript">
            function delete_news(id) {
                if (confirm("确定要删除这篇文章吗？")) {
                    window.location = "action.php?action=delete_news&id=" + id;
                }
            }
        </script>
    </div>
</div>
</body>
</html>