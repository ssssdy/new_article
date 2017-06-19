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
        require './model/news_model.class.php';
        require './model/user_model.class.php';
        require './model/tag_model.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        echo "<ul><li><a href='index.php'>浏览文章</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li>
                        </ul>";
        ?>
    </div>
    <div class="content">
        <h3 align="center">管理员信息</h3>
        <?php
        $news_model = new News_Model();
        $user_model = new User_Model();
        $user_list_info = $user_model->get_all_user_info(ROLE_TYPE_ADMIN);
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page的值，假如不存在page，那么页数就是1
        $page_size = PAGE_SIZE;
        $page_num = ceil(count($user_list_info) / $page_size);
        if ($page > $page_num || $page == 0) {
            echo "Error : Can Not Found The page .";
            exit;
        }
        $offset = ($page - 1) * $page_size;
        $user_limit_info = $user_model->get_limit_user_info($offset, $page_size, ROLE_TYPE_ADMIN);
        ?>
        <table align="center" width="500">
            <tr>
                <th>用户ID</th>
                <th>用户名</th>
                <th>权限</th>
                <th>变更权限</th>
            </tr>
            <?php
            for ($i = 0; $i < count($user_limit_info); $i++) {
                $role_name = $user_model->get_role_name($user_limit_info[$i]['role_type']);
                echo "<tr>";
                echo "<td align='center'>{$user_limit_info[$i]['user_id']}</td>";
                echo "<td align='center'>{$user_limit_info[$i]['user_name']}</td>";
                echo "<td align='center'>$role_name</td>";
                echo "<td align='center'>";
                if ($user_limit_info[$i]['role_type'] <= ROLE_TYPE_EDITOR) {
                    echo "<a href='javascript:change_admin({$user_limit_info[$i]['user_id']})'>升级为管理员</a>";
                } else if ($user_limit_info[$i]['role_type'] == ROLE_TYPE_ADMIN) {
                    echo "<a href='javascript:change_admin({$user_limit_info[$i]['user_id']})'>取消管理员身份</a>";
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
            echo "<a href='addAdmin.php?page=1'>首页 </a>";
            echo "<a href='addAdmin.php?page=" . $prev . "'>上一页</a>";
        }
        if ($page < $page_num) {
            echo "<a href='addAdmin.php?page=" . $next . "'>下一页 </a>";
            echo "<a href='addAdmin.php?page=" . $page_num . "'>尾页</a>";
        }
        for ($j = 1; $j <= $page_num; $j++) {
            $show = ($j != $page) ? "<a href='addAdmin.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
            echo $show . "   ";
        }
        ?>
        <br/>
        <hr width="100%"/>
    </div>
    <script>
        function change_admin(id) {
            if (confirm("确定要升级该用户为管理员吗？")) {
                window.location = "action.php?action=change_admin&id=" + id;
            }
        }
    </script>
</body>
</html>