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
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/lang/zh-cn/zh-cn.js"></script>
    <title>文章管理系统</title>
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
        <div class="menu col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_EDITOR:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="content col-md-10 table-responsive">
            <?php
            $news_model = new News_Model();
            $news_info = $news_model->get_one_news_info($_GET['id']);
            $tag_model = new Tag_Model();
            $tag_info = $tag_model->get_one_tag_info($news_info['tag_id']);
            $tag_list_info = $tag_model->get_all_tag_info();
            $tag_num = count($tag_list_info);
            ?>
            <form action="action.php?action=update" method="post">
                <input type="hidden" name="id" value="<?php echo $news_info['id']; ?>"/>
                <table class="table table-hover">
                    <tr>
                        <td>文章类别：</td>
                        <td>
                            <select name="tag_id" id="tag_name" title="">
                                <?php
                                echo "<option value={$tag_info['tag_id']}>{$tag_info['tag_name']}</option>";
                                for ($i = 0; $i < $tag_num; $i++) {
                                    echo " <option value={$tag_list_info[$i]['tag_id']}>{$tag_list_info[$i]['tag_name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>标题:</td>
                        <td><input title="" type="text" name="title" value="<?= $news_info['title'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>关键字:</td>
                        <td><input title="" type="text" name="keywords" value="<?= $news_info['keywords'] ?>"/></td>
                    </tr>
                    <tr>
                        <td>作者:</td>
                        <td><input title="" type="text" name="author" value="<?= $news_info['author'] ?>"/></td>
                    </tr>
                    <tr>
                        <td>内容:</td>
                        <td><textarea name="content" id="content" title=""><?= $news_info['content'] ?></textarea>
                            <script type="text/javascript">
                                um.getEditor('content');
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td>修改图片：</td>
                        <td><input title="" type="text" name="image_url" value="<?= $news_info['image_url'] ?>"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input size="6" type="submit" value="编辑"/>
                            <input type="reset" value="重置"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            var um = UE.getEditor('content',
                {
                    toolbars: [["source", '|', "undo", "redo", '|', "bold", "italic", "underline", "strikethrough", '|', 'insertorderedlist', 'insertunorderedlist', '|', "superscript", "subscript", '|', "justifyleft", "justifycenter", "justifyright", "justifyjustify", '|', "indent", "rowspacingbottom", "rowspacingtop", "lineheight", "|", 'selectall', 'cleardoc'], ["fontfamily", "fontsize", '|', "forecolor", "backcolor", '|', "pasteplain", 'removeformat', 'formatmatch', "autotypeset", '|', "insertimage", 'music', 'insertvideo', "attachment", '|', "link", "unlink", "spechars", '|', "inserttable", "deletetable"], ['gmap', 'insertframe', 'highlightcode', 'template', 'background', "|", 'horizontal', 'date', 'time', '|', 'print', 'searchreplace', 'preview', "fullscreen"]]
                    , initialFrameWidth: 500
                    , initialFrameHeight: 300
                    , initialContent: ''
                    , wordCount: true
                    , maximumWords: 10000
                    , autoHeightEnabled: false
                    , elementPathEnabled: false
                    , autoFloatEnabled: false
                    , textarea: "content"
                    , initialStyle: 'body{font-size:14px}'
                }
            )
        </script>
    </div>
</div>
</body>
</html>