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
        require("./helpers/global_helper.php");
        require './model/news_info_model.class.php';
        check_login();
        ?>
    </div>
    <div>
            <h3 align="center" style="font-size: 26px">实时新闻</h3>
            <?php
            $news_model = new Real_Time_News_Model();
            $row1 = $news_model->get_real_time_news();
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page的值，假如不存在page，那么页数就是1
            $page_size = 10;
            $page_num = ceil(count($row1) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $row = $news_model->get_limit_real_news($offset, $page_size);
            echo "<ul style='list-style: none;color: #003F76;line-height: 25px;'>";
            for ($i = 0; $i < count($row); $i++) {
                echo "<li>{$row[$i]['content']}</li>";
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
        <br/>
        <hr width="100%"/>
    </div>
</div>
</body>
</html>