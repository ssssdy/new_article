<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="./static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title> 文章主页 </title>

</head>
<body>
<div>
    <div class="login">
        <?php
        require './helpers/global_helper.php';
        require './model/base_model.class.php';
        require './model/news_model.class.php';
        require './model/user_model.class.php';
        require './model/tag_model.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_type']) {
            case "VI":
                break;
            case "ED":
                echo "<ul><li><a href='showNews.php'>实时新闻</a></li>>;
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li></ul>";
                break;
            case "AD":
                echo "<ul><li><a href='showNews.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li></ul>";
                break;
            case "SU":
                echo "<ul><li><a href='showNews.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
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
        <table align="center" width="900">
            <tr>
                <th>文章id</th>
                <th>文章类别</th>
                <th>文章标题</th>
                <th>关键字</th>
                <th>作者</th>
                <th>发布时间</th>
                <th>文章内容</th>
                <th>图片</th>
                <?php
                if (isset($_SESSION['user_name']) && $_SESSION['role_type'] >= 1) {
                    echo "<th>操作</th>";
                }
                ?>
            </tr>
            <?php
            $news_model = new News_Model();
            $redis = new redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->select(1);
            $blog = $redis->lrange('news_list', 0, 20);
            //如果$blog数组为空，则去数据库中查询，并加入到redis中
            if (empty($blog)) {
                echo "缓存中没有数据,正从MySQL数据库调取数据存入缓存"."<br>";
                $info = $news_model->get_all_news_info();
//                dump($info[0]['title']);
                $num = count($info);
                $redis->select(1);
                for ($i = 0; $i < $num; $i++) {
                    $redis->rpush('news_list', json_encode($info[$i]));
                }
                $redis_blog = $redis->lRange('news_list', 0, $num - 1);
            } else {
                echo "缓存中有数据,直接调取"."<br>";
                $redis_blog = $redis->lRange('news_list', 0, 20);
                $news = json_decode($redis_blog[0], true);
//                print_r($news['title']);
            }
            $dir = "http://orc8koj7r.bkt.clouddn.com/";
            $img_model = "?imageView2/2/w/200/h/200/q/75|watermark/1/image/aHR0cHM6Ly9vanBibHkxdW4ucW5zc2wuY29tL2xvZ28ucG5n/dissolve/100/gravity/SouthEast/dx/10/dy/10|imageslim";
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
            $page_size = 5;
            echo "总文章数:".count($redis_blog);
            $page_num = ceil(count($redis_blog) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $row1 = $redis->lRange('news_list', $offset, $page * $page_size - 1);
//            dump($row1);
            for ($i = 0; $i < count($row1); $i++) {
                $row2 = json_decode($row1[$i], true);
                $tag_model = new Tag_Model();
                $tag_row = $tag_model->get_one_tag_info($row2['tag_id']);
                echo "<tr>";
                echo "<td align='center'>{$row2['id']}</td>";
                echo "<td align='center'>{$tag_row['tag_name']}</td>";
                echo "<td align='center'>{$row2['title']}</td>";
                echo "<td align='center'>{$row2['keywords']}</td>";
                echo "<td align='center' width='100'>{$row2['author']}</td>";
                echo "<td align='center'>" . date("Y-m-d", $row2['add_time']) . "</td>";
                echo "<td align='center'>{$row2['content']}</td>";
                echo "<td width=\"100\" height=\"100\">
                  <img width='100' height='100' src='" . $dir . $row2['image_name'] . $img_model . "'/>
                  </td>";
                if ($_SESSION['role_type'] >= 1) {
                    echo "<td align='center'>";
                    echo "<a href='editArticle.php?id={$row2['id']}'>编辑文章</a><br/>";
                    if ($_SESSION['role_type'] >= 2) {
                        echo "<a href='javascript:dodel({$row2['id']})'>删除文章</a>";
                    }
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
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
        ?>
        <br/>
        <hr width="100%"/>
    </div>
    <script type="text/javascript">
        function dodel(id) {
            if (confirm("确定要删除这篇文章吗？")) {
                window.location = "action.php?action=delete_news&id=" + id;
            }
        }
    </script>
</div>
</body>
</html>