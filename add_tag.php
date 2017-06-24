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
                check_login();
                ?>
            </ul>
        </div>
    </div>
</nav
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-10 table-responsive">
            <form action="action.php?action=add_tag" method="post">
                <input type="text" name="tag_name" placeholder="输入您要添加的类别"/>
                <input type="submit" value="添加"/>
            </form>
            <br/>
            <table class="table table-hover">
                <tr>
                    <th>文章类别编号</th>
                    <th>文章类别名称</th>
                    <th>操作</th>
                </tr>
                <?php
                $tag_model = new Tag_Model();
                $tag_info_list = $tag_model->get_all_tag_info();
                $tag_num = count($tag_info_list);
                for ($i = 0; $i < $tag_num; $i++) {
                    echo "<tr>";
                    echo "<td>{$tag_info_list[$i]['tag_id']}</td>";
                    echo "<td>{$tag_info_list[$i]['tag_name']}</td>";
                    echo "<td><a href = 'javascript:delete_tag({$tag_info_list[$i]['tag_id']})' onclick=''>删除该类别</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function delete_tag(tag_id) {
        if (confirm("确定要删除该文章类别吗？")) {
            window.location = "action.php?action=delete_tag&tag_id=" + tag_id;
        }
    }
</script>
</body>
</html>