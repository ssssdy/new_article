<html>
<head>
    <meta charset="utf-8">
    <link href="/static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title>文章管理系统</title>
</head>
<h3 align="center">文章分类</h3>
<body>
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
        case ROLE_TYPE_ADMIN:
            echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li></ul>";
            break;
        case ROLE_TYPE_SUPER:
            echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
            break;
    }
    ?>
</div>
<div class="content">
    <form action="action.php?action=add_tag" method="post">
        <input type="text" name="tag_name" placeholder="输入您要添加的类别"/>
        <input type="submit" value="添加"/>
    </form>
    <table width="500">
        <tr>
            <th align="center" width="120">文章类别编号</th>
            <th align="center" width="150">文章类别名称</th>
            <th align="center">操作</th>
        </tr>
        <?php
        $tag_model = new Tag_Model();
        $tag_info_list = $tag_model->get_all_tag_info();
        $tag_num = count($tag_info_list);
        for ($i = 0; $i < $tag_num; $i++) {
            echo "<tr>";
            echo "<td align='center'>{$tag_info_list[$i]['tag_id']}</td>";
            echo "<td align='center'>{$tag_info_list[$i]['tag_name']}</td>";
            echo "<td align='center'><a href = 'javascript:dodel({$tag_info_list[$i]['tag_id']})' onclick=''>删除该类别</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<script type="text/javascript">
    function dodel(tag_id) {
        if (confirm("确定要删除该文章类别吗？")) {
            window.location = "action.php?action=delete_tag&tag_id=" + tag_id;
        }
    }
</script>
</body>
</html>