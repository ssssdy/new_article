<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="./lib/bootstrap_demo/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap_demo/dist/js/bootstrap.min.js"></script>
    <title> 文章管理系统 </title>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">文章系统</a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">下拉菜单<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">jmeter</a></li>
                        <li><a href="#">EJB</a></li>
                        <li><a href="#">Jasper Report</a></li>
                        <li class="divider"></li>
                        <li><a href="#">分离的链接</a></li>
                        <li class="divider"></li>
                        <li><a href="#">另一个分离的链接</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                require './helpers/global_helper.php';
                require './model/news_model.class.php';
                require './model/user_model.class.php';
                require './model/tag_model.class.php';
                require './cache/base_cache.class.php';
                session_start();
                if (isset($_SESSION['user_name'])) {
                    echo "<li><p class='navbar-text navbar-right'>欢迎" . $_SESSION['role_name'] . $_SESSION['user_name'] . " 登录！" . "</p></li>";
                    echo '<li><a href="action.php?action=logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>';
                } else {
                    echo '<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> 注册</a></li>';
                    echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li>
                        </ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-6 table-responsive">
            <?php
            $news_model = new News_Model();
            $user_model = new User_Model();
            $user_general_list_info = $user_model->get_general_user_info(ROLE_TYPE_EDITOR);
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//这句就是获取page=18中的page的值，假如不存在page，那么页数就是1
            $page_size = PAGE_SIZE;
            $page_num = ceil(count($user_general_list_info) / $page_size);
            if ($page > $page_num || $page == 0) {
                echo "Error : Can Not Found The page .";
                exit;
            }
            $offset = ($page - 1) * $page_size;
            $user_all_list_info = $user_model->get_limit_user_info($offset, $page_size, ROLE_TYPE_EDITOR);
            ?>
            <table class="table table-hover">
                <tr>
                    <th>用户ID</th>
                    <th>用户名</th>
                    <th>权限ID</th>
                    <th>变更权限</th>
                </tr>
                <?php
                for ($i = 0; $i < count($user_all_list_info); $i++) {
                    $role_name = $user_model->get_role_name($user_all_list_info[$i]['role_type']);
                    echo "<tr>";
                    echo "<td>{$user_all_list_info[$i]['user_id']}</td>";
                    echo "<td>{$user_all_list_info[$i]['user_name']}</td>";
                    echo "<td>$role_name</td>";
                    echo "<td>";
                    if ($user_all_list_info[$i]['role_type'] == ROLE_TYPE_VISITOR) {
                        echo "<a href='javascript:change_editor({$user_all_list_info[$i]['user_id']})'>升级为编辑</a>";
                    } else if ($user_all_list_info[$i]['role_type'] == ROLE_TYPE_EDITOR) {
                        echo "<a href='javascript:change_editor({$user_all_list_info[$i]['user_id']})'>取消编辑身份</a>";
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
                echo "<a href='add_editor.php?page=1'>首页 </a>";
                echo "<a href='add_editor.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='add_editor.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='add_editor.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($i = 1; $i <= $page_num; $i++) {
                $show = ($i != $page) ? "<a href='add_editor.php?page=" . $i . "'>[$i]</a>" : "<b>[$i]</b>";
                echo $show . "   ";
            }
            ?>
            <br/>
            <hr width="100%"/>
        </div>
        <script type="text/javascript">
            function change_editor(id) {
                if (confirm("确定要升级该游客为编辑吗？")) {
                    window.location = "action.php?action=change_editor&id=" + id;
                }
            }
        </script>
    </div>
</div>
</body>
</html>