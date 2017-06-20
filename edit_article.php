<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="./lib/qiniu_ueditor/lang/zh-cn/zh-cn.js"></script>
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
        switch ($_SESSION['role_type']) {
            case ROLE_TYPE_EDITOR:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
                echo "<ul><li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content">
        <?php
        $news_model = new News_Model();
        $news_info = $news_model->get_one_news_info($_GET['id']);
        $tag_model = new Tag_Model();
        $tag_info = $tag_model->get_one_tag_info($news_info['tag_id']);
        $tag_list_info = $tag_model->get_all_tag_info();
        $tag_num = count($tag_list_info);
        ?>
        <h2 align="center">编辑文章</h2>
        <form action="action.php?action=update" method="post">
            <input type="hidden" name="id" value="<?php echo $news_info['id']; ?>"/>
            <table align="center">
                <caption style="font-size: 26px">编辑文章</caption>
                <tr>
                    <td align="center">文章类别：</td>
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
                    <td align="center">标题:</td>
                    <td width="90"><input title="" type="text" name="title" value="<?= $news_info['title'] ?>"/></td>
                </tr>
                <tr>
                    <td align="center">关键字:</td>
                    <td><input title="" type="text" name="keywords" value="<?= $news_info['keywords'] ?>"/></td>
                </tr>
                <tr>
                    <td align="center">作者:</td>
                    <td><input title="" type="text" name="author" value="<?= $news_info['author'] ?>"/></td>
                </tr>
                <tr>
                    <td align="center">内容:</td>
                    <td><textarea name="content" id="content" title=""><?= $news_info['content'] ?></textarea>
                        <script type="text/javascript">
                            um.getEditor('content');
                        </script>
                    </td>
                </tr>
                <tr>
                    <td align='center'>修改图片：</td>
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