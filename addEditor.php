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
        require './model/base_model.class.php';
        require './model/news_model.class.php';
        require './model/user_model.class.php';
        require './model/tag_model.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_id']) {
            case "2":
                echo "<ul><li><a href='index.php'>浏览文章</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li></ul>";
                break;
            case "3":
                echo "<ul><li><a href='index.php'>浏览文章</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li>
                        </ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <h3 align="center">用户信息</h3>
        <?php
        $news_model = new News_Model();
        $user_model = new User_Model();
        $row1 = $user_model->get_general_user_info();
        //        dump($row1);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
        $page_size = 10;
        $page_num = ceil(count($row1) / $page_size);
        if ($page > $page_num || $page == 0) {
            echo "Error : Can Not Found The page .";
            exit;
        }
        $offset = ($page - 1) * $page_size;
        $row = $user_model->get_limit_user_info($offset, $page_size,1);
        ?>
        <table align="center" width="600">
            <tr>
                <th>用户名</th>
                <th>权限ID</th>
                <th>变更权限</th>
            </tr>
            <?php
            for ($i = 0; $i < count($row); $i++) {
                $role_name = $user_model->get_role_name($row[$i]['role_id']);
                echo "<tr>";
                echo "<td align='center'>{$row[$i]['user_name']}</td>";
                echo "<td align='center'>{$row[$i]['user_id']}$role_name</td>";
                echo "<td align='center'>";
                if ($row[$i]['role_id'] == 0) {
                    echo $row1[$i]['role_id'];
                    echo "<a href='javascript:upChange({$row[$i]['user_id']})'>升级为编辑</a>";
                } else if ($row[$i]['role_id'] == 1) {
                    echo $row1[$i]['role_id'];
                    echo "<a href='javascript:downChange({$row[$i]['user_id']})'>取消编辑身份</a>";
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
            echo "<a href='addEditor.php?page=1'>首页 </a>";
            echo "<a href='addEditor.php?page=" . $prev . "'>上一页</a>";
        }
        if ($page < $page_num) {
            echo "<a href='addEditor.php?page=" . $next . "'>下一页 </a>";
            echo "<a href='addEditor.php?page=" . $page_num . "'>尾页</a>";
        }
        for ($i = 1; $i <= $page_num; $i++) {
            $show = ($i != $page) ? "<a href='addEditor.php?page=" . $i . "'>[$i]</a>" : "<b>[$i]</b>";
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