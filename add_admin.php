<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="./lib/bootstrap_demo/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/dist/css/sb-admin-2.css" rel="stylesheet">
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap_demo/dist/js/bootstrap.min.js"></script>
    <link href="./lib/bootstrap_demo/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                check_login();
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            echo "<ul class=\"nav nav-tabs nav-stacked\"><li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        </ul>";
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="content col-md-10 table-responsive">
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
            <table class="table table-hover">
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
                    echo "<td>{$user_limit_info[$i]['user_id']}</td>";
                    echo "<td>{$user_limit_info[$i]['user_name']}</td>";
                    echo "<td>$role_name</td>";
                    echo "<td>";
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
                echo "<a href='add_admin.php?page=1'>首页 </a>";
                echo "<a href='add_admin.php?page=" . $prev . "'>上一页</a>";
            }
            if ($page < $page_num) {
                echo "<a href='add_admin.php?page=" . $next . "'>下一页 </a>";
                echo "<a href='add_admin.php?page=" . $page_num . "'>尾页</a>";
            }
            for ($j = 1; $j <= $page_num; $j++) {
                $show = ($j != $page) ? "<a href='add_admin.php?page=" . $j . "'>[$j]</a>" : "<b>[$j]</b>";
                echo $show . "   ";
            }
            ?>
            <br/>
            <hr width="100%"/>
        </div>
    </div>
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