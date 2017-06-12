<html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='login.php'</script>";
}
?>
<head>
    <meta charset="utf-8">
    <link href="/static/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" charset="utf-8" src="lib/qiniu_ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="lib/qiniu_ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="lib/qiniu_ueditor/lang/zh-cn/zh-cn.js"></script>
    <title>文章管理系统</title>
</head>
<body>
<div>
    <h2>文章管理系统</h2>
    <div class="login">
        <tr>
            <?php
            if (isset($_SESSION['username'])) {
                echo "欢迎 " . $_SESSION['role_name'] . "  " . $_SESSION['username'] . " 登录！";
//                echo $_SESSION['role_id'];
                echo "<br/>";
                echo "<a href='action.php?action=logout'>注销登录  </a>";
                echo "<a href='register.php'>  注册</a>";
            } else {
                echo "您还没有登录！请先 ";
                echo "<a href='login.php'>登录 </a>";
                echo "<a href='register.php'>注册</a>";
            }
            ?>
        </tr>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_id']) {
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
                        <li><a href='vaddAdmin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <center>
            <?php
            require("/helpers/globle_helper.php");
            require '/models/news_model.class.php';
            require '/models/tag_model.class.php';
            require("/static/dbconfig.php");
            $link = new Tag_Model();
            $tag = $link->get_AllTags_info();
            $total_num = count($tag);
            ?>
            <h3>发布文章</h3>
            <form action="action.php?action=add" method="post">
                <table width="800">
                    <tr>
                        <td align="center">文章类别：</td>
                        <td>
                            <select name='tag_id' id='tag_name'>
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
                        <td><input type="text" name="title"/></td>
                    </tr>
                    <tr>
                        <td align="center">关键字：</td>
                        <td><input type="text" name="keywords"/></td>
                    </tr>
                    <tr>
                        <td align="center">作者：</td>
                        <td><input type="text" name="author"/></td>
                    </tr>
                    <tr>
                        <td align="center">内容：</td>
                        <td><textarea name="content" id="content"></textarea>
                            <script type="text/javascript">
                                um.getEditor(' content ')
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">图片名：</td>
                        <td><input type="text" name="image_name"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" value="添加"/>
                            <input type="reset" value="重置">
                        </td>
                    </tr>
                </table>
            </form>
        </center>
    </div>
    <script type="text/javascript">
        var um = UE.getEditor('content',
            {
                toolbars: [["source", '|', "undo", "redo", '|', "bold", "italic", "underline", "strikethrough", '|', 'insertorderedlist', 'insertunorderedlist', '|', "superscript", "subscript", '|', "justifyleft", "justifycenter", "justifyright", "justifyjustify", '|', "indent", "rowspacingbottom", "rowspacingtop", "lineheight", "|", 'selectall', 'cleardoc'], ["fontfamily", "fontsize", '|', "forecolor", "backcolor", '|', "pasteplain", 'removeformat', 'formatmatch', "autotypeset", '|', "insertimage", 'music', 'insertvideo', "attachment", '|', "link", "unlink", "spechars", '|', "inserttable", "deletetable"], ['gmap', 'insertframe', 'highlightcode', 'template', 'background', "|", 'horizontal', 'date', 'time', '|', 'print', 'searchreplace', 'preview', "fullscreen"]]
                , initialFrameWidth: 550  //初始化编辑器宽度,默认1000
                , initialFrameHeight: 300  //初始化编辑器高度,默认320
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
</body>
</html>