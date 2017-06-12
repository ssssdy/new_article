<html>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='login.php'</script>";
}
?>
<head>
    <link href="/static/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" charset="utf-8" src="/lib/qiniu_ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/lib/qiniu_ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/lib/qiniu_ueditor/lang/zh-cn/zh-cn.js"></script>
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
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <center>
            <?php
            include("/helpers/globle_helper.php");
            require("/models/news_model.class.php");
            require("/models/tag_model.class.php");
            require("/static/dbconfig.php");
            check_session();
            $link1 = new News_Model();
            $news = $link1->get_OneNews_info($_GET['id']);
            $link2 = new Tag_Model();
            $tag = $link2->get_OneTags_info($news['tag_id']);
            $tag1 = $link2->get_AllTags_info();
            $tag_num = count($tag1);
            ?>
            <h2 align="center">编辑文章</h2>
            <form action="action.php?action=update" method="post">
                <input type="hidden" name="id" value="<?php echo $news['id']; ?>"/>
                <table width="800">
                    <tr>
                        <td align="center">文章类别：</td>
                        <td>
                            <select name="tag_id" id="tag_name">
                                <option value=0><?php echo $tag['tag_name']; ?></option>
                                <?php
                                for ($i = 0; $i < $tag_num; $i++) {
                                    echo " <option value={$tag1[$i]['tag_id']}>{$tag1[$i]['tag_name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">标题:</td>
                        <td width="90"><input type="text" name="title" value="<?php echo $news['title']; ?>"/></td>
                    </tr>
                    <tr>
                        <td align="center">关键字:</td>
                        <td><input type="text" name="keywords" value="<?php echo $news['keywords']; ?>"/></td>
                    </tr>
                    <tr>
                        <td align="center">作者:</td>
                        <td><input type="text" name="author" value="<?php echo $news['author']; ?>"/></td>
                    </tr>
                    <tr>
                        <td align="center">内容:</td>
                        <td><textarea name="content" id="content"><?php echo $news['content']; ?></textarea>
                            <script type="text/javascript">
                                um.getEditor('content')
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td align='center'>修改图片：</td>
                        <td><input type="text" name="image_name" value="<?php echo $news['image_name']; ?>"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input size="6" type="submit" value="编辑"/>
                            <input type="reset" value="重置"/>
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
                , initialFrameWidth: 550
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
</body>
</html>