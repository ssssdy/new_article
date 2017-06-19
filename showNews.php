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
        require './model/news_model.class.php';
        require './model/real_news_model.class.php';
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
                        <li><a href='addArticle.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <h3 align="center" style="font-size: 26px">实时新闻</h3>
            <?php
            $real_news_model = new Real_News_Model();
            $redis = new Base_Cache();
            $data_status = $redis->is_exists('real_news');
            if ($data_status == 0) {
                $real_news_list_info = $real_news_model->get_real_time_news();
                $num = count($real_news_list_info);
                for ($i = 0; $i < $num; $i++) {
                    $redis->r_push('real_news', $real_news_list_info[$i]['content'], SURVIVAL_TIME);
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
            echo "<ul style='list-style: none;color: #003F76;line-height: 25px;'>";
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
            echo "<div align='center'>共 " . $page_num . " 页 ";
            if ($page > 1) {
                echo "<a href='showNews.php?page=1'>首页 </a>";
                echo "<a href='showNews.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='showNews.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='showNews.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($j = 1; $j <= $page_num; $j++) {
                $show = ($j != $page) ? "<a href='showNews.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
                echo $show . "   ";
            }
            ?>
        <br/>
        <hr width="100%"/>
    </div>
</div>
</body>
</html>