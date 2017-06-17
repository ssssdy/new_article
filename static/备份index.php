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
        require './model/tag_model.class.php';
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
            <caption style="font-size: 26px">文章信息</caption>
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
            $row1 = $news_model->get_all_news_info();
            $dir = "http://orc8koj7r.bkt.clouddn.com/";
            $img_model = "?imageView2/2/w/200/h/200/q/75|watermark/1/image/aHR0cHM6Ly9vanBibHkxdW4ucW5zc2wuY29tL2xvZ28ucG5n/dissolve/100/gravity/SouthEast/dx/10/dy/10|imageslim";
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
            $page_size = 4;
            $page_num = ceil(count($row1) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $row = $news_model->get_limit_news_info($offset, $page_size);
            for ($i = 0; $i < count($row); $i++) {
                $tag_model = new Tag_Model();
                $tag_row = $tag_model->get_one_tag_info($row[$i]['tag_id']);
                echo "<tr>";
                echo "<td align='center'>{$row[$i]['id']}</td>";
                echo "<td align='center'>{$tag_row['tag_name']}</td>";
                echo "<td align='center'>{$row[$i]['title']}</td>";
                echo "<td align='center'>{$row[$i]['keywords']}</td>";
                echo "<td align='center' width='100'>{$row[$i]['author']}</td>";
                echo "<td align='center'>" . date("Y-m-d", $row[$i]['add_time']) . "</td>";
                echo "<td align='center'>{$row[$i]['content']}</td>";
                echo "<td width=\"100\" height=\"100\">
                  <img width='100' height='100' src='" . $dir . $row[$i]['image_name'] . $img_model . "'/>
                  </td>";
                if ($_SESSION['role_type'] >= 1) {
                    echo "<td align='center'>";
                    echo "<a href='editArticle.php?id={$row[$i]['id']}'>编辑文章</a><br/>";
                    if ($_SESSION['role_type'] >= 2) {
                        echo "<a href='javascript:dodel({$row[$i]['id']})'>删除文章</a>";
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