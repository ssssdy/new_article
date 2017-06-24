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
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_EDITOR:
                    echo "<ul class=\"nav nav-tabs nav-stacked\"></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
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
        <div class="col-md-10 table-responsive">
            <?php
            $tag_model = new Tag_Model();
            $tag = $tag_model->get_all_tag_info();
            $total_num = count($tag);
            ?>
            <form action="action.php?action=add" method="post">
                <table class="table table-hover">
                    <tr>
                        <td align="center">文章类别：</td>
                        <td>
                            <select name='tag_id' id='tag_name' title="">
                                <option value=0>---请选择---</option>
                                <?php
                                for ($i = 0; $i < $total_num; $i++) {
                                    echo "<option value={$tag[$i]['tag_id']}>{$tag[$i]['tag_name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">标题：</td>
                        <td><input type="text" name="title" title="label"/></td>
                    </tr>
                    <tr>
                        <td align="center">关键字：</td>
                        <td><input type="text" name="keywords" title=""/></td>
                    </tr>
                    <tr>
                        <td align="center">作者：</td>
                        <td><input type="text" name="author" title=""/></td>
                    </tr>
                    <tr>
                        <td align="center">内容：</td>
                        <td><textarea name="content" id="content" title=""></textarea>
                            <script type="text/javascript">
                                um.getEditor(' content ')
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">图片名：</td>
                        <td><input type="text" name="image_url" title=""/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="添加"/>
                            <input type="reset" value="重置">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            var um = UE.getEditor('content',
                {
                    toolbars: [["source", '|', "undo", "redo", '|', "bold", "italic", "underline", "strikethrough", '|', 'insertorderedlist', 'insertunorderedlist', '|', "superscript", "subscript", '|', "justifyleft", "justifycenter", "justifyright", "justifyjustify", '|', "indent", "rowspacingbottom", "rowspacingtop", "lineheight", "|", 'selectall', 'cleardoc'], ["fontfamily", "fontsize", '|', "forecolor", "backcolor", '|', "pasteplain", 'removeformat', 'formatmatch', "autotypeset", '|', "insertimage", 'music', 'insertvideo', "attachment", '|', "link", "unlink", "spechars", '|', "inserttable", "deletetable"], ['gmap', 'insertframe', 'highlightcode', 'template', 'background', "|", 'horizontal', 'date', 'time', '|', 'print', 'searchreplace', 'preview', "fullscreen"]]
                    , initialFrameWidth: 550  //初始化编辑器宽度,默认1000
                    , initialFrameHeight: 250  //初始化编辑器高度,默认320
                    , initialContent: ''   //初始化编辑器的内容,也可以通过textarea/script给值，看官网例子
                    , wordCount: true          //是否开启字数统计
                    , maximumWords: 10000       //允许的最大字符数
                    , autoHeightEnabled: false // 是否自动长高,默认true
                    , elementPathEnabled: false //左下角显示元素路径
                    , autoFloatEnabled: false //工具栏浮动
                    , textarea: "content"
                    , initialStyle: 'body{font-size:14px}'   //编辑器内部样式,可以用来改变字体等
                }
            )
        </script>
    </div>
</div>
</body>
</html>