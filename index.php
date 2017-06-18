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
                echo "<ul><li><a href='showNews.php'>实时新闻</a></li>>;
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul><li><a href='showNews.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
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
            $redis = new Base_cache();
            $blog = $redis->isExists('news_list');
            if ($blog == 0) {
                echo "数据库有数据修改" . "<br>";
                $news_info_list = $news_model->get_all_news_info();
                $num = count($news_info_list);
                foreach ($news_info_list as $news_info) {
                    $redis->rPush('news_list', json_encode($news_info), 86400);
                }
            }
            $list_length = $redis->lLen('news_list');
            echo "缓存中总数量:" . $list_length . "<br>";
            $redis_blog = $redis->lRange('news_list', 0, $list_length);
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
            $page_size = 5;
            $page_num = ceil(count($redis_blog) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $news_info_list_redis = $redis->lRange('news_list', $offset, $page * $page_size - 1);
            for ($i = 0; $i < count($news_info_list_redis); $i++) {
                $news_info_redis = json_decode($news_info_list_redis[$i], true);
                $tag_model = new Tag_Model();
                $tag_info = $tag_model->get_one_tag_info($news_info_redis['tag_id']);
                echo "<tr>";
                echo "<td align='center'>{$news_info_redis['id']}</td>";
                echo "<td align='center'>{$tag_info['tag_name']}</td>";
                echo "<td align='center'>{$news_info_redis['title']}</td>";
                echo "<td align='center'>{$news_info_redis['keywords']}</td>";
                echo "<td align='center' width='100'>{$news_info_redis['author']}</td>";
                echo "<td align='center'>" . date("Y-m-d", $news_info_redis['add_time']) . "</td>";
                echo "<td align='center'>{$news_info_redis['content']}</td>";
                echo "<td width=\"100\" height=\"100\">
                  <img width='100' height='100' src='" . qiniu_image_display($news_info_redis['image_url']) . "'/>
                  </td>";
                if ($_SESSION['role_type'] >= ROLE_TYPE_EDITOR) {
                    echo "<td align='center'>";
                    echo $news_info_redis['id'];
                    echo "<a href='editArticle.php?id={$news_info_redis['id']}'>编辑文章</a><br/>";
                    if ($_SESSION['role_type'] >= ROLE_TYPE_ADMIN) {
                        echo "<a href='javascript:dodel({$news_info_redis['id']})'>删除文章</a>";
//                        echo "<a href='action.php?action=delete({$news_info_redis['id']})'>删除文章</a>";
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