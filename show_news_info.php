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
        require './model/base_model.class.php';
        require './model/news_model.class.php';
        require './model/user_model.class.php';
        require './model/real_news_model.class.php';
        require './model/tag_model.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_id']) {
            case "0":
                break;
            case "1":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li></ul>";
                break;
            case "2":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>变更用户权限</a></li></ul>";
                break;
            case "3":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>变更用户权限</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <h3 align="center" style="font-size: 26px">实时新闻</h3>
        <table>
            <?php
            $real_news_model = new Real_News_Model();
            $redis = new redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->select(4);
            $blog = $redis->lrange('real_news',0,19);
            //如果$blog数组为空，则去数据库中查询，并加入到redis中
//            dump($blog);
            if (empty($blog)) {
                $rs = $real_news_model->get_real_time_news();
//                dump($rs);
                $num = count($rs);
                $redis->select(4);
                for ($i = 0; $i <= $num; $i++) {
                    $redis->rpush('real_news', $rs[$i]['content']);
                }
                $redis_blog = $redis->lRange('real_news', 0, $num-1);
//                print_r($redis_blog[5]);
            } else {
                $redis_blog = $redis->lRange('real_news',0,19);
//                print_r($redis_blog);
            }
            echo "新闻总数量:".count($redis_blog)."<br>";
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page的值，假如不存在page，那么页数就是1
            $page_size = 6;
            $page_num = ceil(count($redis_blog) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $row =$redis->lRange('real_news',$offset,$page*$page_size-1);
            echo "当页新闻数量:".count($row);
            echo "<ul style='list-style: none;color: #003F76;line-height: 25px;'>";
            for ($i = 0; $i < count($row); $i++) {
                echo "<li>{$row[$i]}</li>";
            }
            echo "</ul>";
            ?>

            <?php
            $prev = $page - 1;
            $next = $page + 1;
            echo "<br/>";
            echo "<div align='center'>共 " . $page_num . " 页 ";
            if ($page > 1) {
                echo "<a href='show_news_info.php?page=1'>首页 </a>";
                echo "<a href='show_news_info.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='show_news_info.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='show_news_info.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($j = 1; $j <= $page_num; $j++) {
                $show = ($j != $page) ? "<a href='show_news_info.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
                echo $show . "   ";
            }
            ?>
        </table>
        <br/>
        <hr width="100%"/>
    </div>
</div>
</body>
</html>