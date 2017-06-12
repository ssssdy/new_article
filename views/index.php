<html>
<?php
require_once '../models/news_model.class.php';
require_once '../models/tag_model.class.php';
require_once '../static/globle_helper.php';
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title> 文章管理系统主页 </title>
    <script type="text/javascript">
        function dodel(id) {
            if (confirm("确定要删除这篇文章吗？")) {
                window.location = "../controllers/action.php?action=del&id=" + id;
            }
        }
    </script>
</head>
<body>
<div>
<!--    <h2 align="center">文章管理系统</h2>-->
    <div class="login">
        <tr>
            <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo "欢迎 " . $_SESSION['role_name'] . "  " . $_SESSION['username'] . " 登录！";
//                echo $_SESSION['role_id'];
                echo "<br/>";
                echo "<a href='../controllers/action.php?action=logout'>注销登录  </a>";
                echo "<a href='register.php'>  注册</a>";
            } else {
                echo "您还没有登录哦！请先 ";
                echo "<a href='login.php'>登录 </a>";
                echo "<a href='register.php'>注册</a>";
            }
            ?>
        </tr>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_id']) {
            case "0":
                break;
            case "1":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add.php'>添加文章</a></li></ul>";
                break;
            case "2":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add.php'>添加文章</a></li>
                        <li><a href='handle.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>添加文章分类</a></li>
                        <li><a href='addEidtor.php'>变更用户权限</a></li></ul>";
                break;
            case "3":
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add.php'>添加文章</a></li>
                        <li><a href='handle.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>添加文章分类</a></li>
                        <li><a href='addEidtor.php'>变更用户权限</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <table align="center" width="900">
            <caption>文章信息</caption>
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
                if (isset($_SESSION['username'])&&$_SESSION['role_id'] >= 1) {
                    echo "<th>操作</th>";
                }
                ?>
            </tr>
            <?php
            $link = new News_Model();
            $row1 = $link->get_AllNews_info();
            $dir = "http://orc8koj7r.bkt.clouddn.com/";
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
            $pagesize = 4;
            $pagenum = ceil(count($row1) / $pagesize);
            if ($page > $pagenum || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $pagesize;
            $row = $link->get_LimitNews_info($offset, $pagesize);
            for ($i = 0; $i < count($row); $i++) {
                $tag = new Tag_Model();
                $tag_row = $tag->get_OneTags_info($row[$i]['tag_id']);
                echo "<tr>";
                echo "<td align='center'>{$row[$i]['id']}</td>";
                echo "<td align='center'>{$tag_row['tag_name']}</td>";
                echo "<td align='center'>{$row[$i]['title']}</td>";
                echo "<td align='center'>{$row[$i]['keywords']}</td>";
                echo "<td align='center' width='100'>{$row[$i]['author']}</td>";
                echo "<td align='center'>" . date("Y-m-d", $row[$i]['addtime']) . "</td>";
                echo "<td align='center'>{$row[$i]['content']}</td>";
                echo "<td width=\"100\" height=\"100\">
                  <img width='100' height='100' src='" . $dir . $row[$i]['image_name'] . "'/>
                  </td>";
                if ($_SESSION['role_id'] >= 1) {
                    echo "<td align='center'>";
                    echo "<a href='edit.php?id={$row[$i]['id']}'>编辑文章</a><br/>";
                    if ($_SESSION['role_id'] >= 2) {
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
        echo "<div align='center'>共 " . $pagenum . " 页 ";
        if ($page > 1) {
            echo "<a href='index.php?page=1'>首页 </a>";
            echo "<a href='index.php?page=" . $prev . "'>上一页</a>";
        }
        if ($page < $pagenum) {
            echo "<a href='index.php?page=" . $next . "'>下一页 </a>";
            echo "<a href='index.php?page=" . $pagenum . "'>尾页</a>";
        }
        for ($j = 1; $j <= $pagenum; $j++) {
            $show = ($j != $page) ? "<a href='index.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
            echo $show . "   ";
        }
        ?>
        <br/>
        <hr width="100%"/>
    </div>
</div>
</body>
</html>