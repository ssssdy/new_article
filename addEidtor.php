<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <title>文章管理系统</title>
</head>
<body>
<div>
    <h2>文章管理系统</h2>
    <div class="login">
        <?php
        require './helpers/global_helper.php';
        require './models/news_model.class.php';
        require './models/tag_model.class.php';
        require './models/user_model.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_id']) {
            case "2":
                echo "<ul><li><a href='index.php'>浏览文章</a></li>
                        <li><a href='add.php'>添加文章</a></li>
                        <li><a href='handle.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li></ul>";
                break;
            case "3":
                echo "<ul><li><a href='index.php'>浏览文章</a></li>
                        <li><a href='add.php'>添加文章</a></li>
                        <li><a href='handle.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <h3 align="center">用户信息</h3>
        <?php
        $link = new News_Model();
        $link1 = new User_Model();
        $row1 = $link1->get_general_user_info();
        //        dump($row1);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
        $pagesize = 10;
        $pagenum = ceil(count($row1) / $pagesize);
        if ($page > $pagenum || $page == 0) {
            echo "Error : Can Not Found The page .";
            exit;
        }
        $offset = ($page - 1) * $pagesize;
        $row = $link1->get_limit_user_info($offset, $pagesize);
        ?>
        <table align="center" width="600">
            <tr>
                <th>用户名</th>
                <th>权限ID</th>
                <th>变更权限</th>
            </tr>
            <?php
            for ($i = 0; $i < count($row1); $i++) {
                $role_name = $link1->get_role_name($row1[$i]['role_id']);
                echo "<tr>";
                echo "<td align='center'>{$row1[$i]['user_name']}</td>";
                echo "<td align='center'>$role_name</td>";
                echo "<td>";
                if ($row1[$i]['role_id'] == 0) {
                    echo "<a href='javascript:upChange({$row1[$i]['role_id']})'>升级为编辑</a>";
                } else if ($row1[$i]['role_id'] == 1) {
                    echo "<a href='javascript:downChange({$row1[$i]['role_id']})'>取消编辑身份</a>";
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
            echo "<a href='addEidtor.php?page=1'>首页 </a>";
            echo "<a href='addEidtor.php?page=" . $prev . "'>上一页</a>";
        }
        if ($page < $pagenum) {
            echo "<a href='addEidtor.php?page=" . $next . "'>下一页 </a>";
            echo "<a href='addEidtor.php?page=" . $pagenum . "'>尾页</a>";
        }
        for ($i = 1; $i <= $pagenum; $i++) {
            $show = ($i != $page) ? "<a href='addEidtor.php?page=" . $i . "'>[$i]</a>" : "<b>[$i]</b>";
            echo $show . "   ";
        }
        ?>
        <br/>
        <hr width="100%"/>
    </div>
    <script type="text/javascript">
        function upChange(id) {
            if (confirm("确定要升级该游客为编辑吗？")) {
                window.location = "action.php?action=change_role1&id=" + id;
            }
        }
        function downChange(id) {
            if (confirm("确定取消该用户编辑权吗？")) {
                window.location = "action.php?action=change_role1&id=" + id;
            }
        }
    </script>
</body>
</html>