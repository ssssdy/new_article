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
    <div class="col-md-2">
        <?php
        switch ($_SESSION['role_type']) {
            case ROLE_TYPE_VISITOR:
                break;
            case ROLE_TYPE_EDITOR:
                echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
                echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="col-md-10">
        <?php
        require './lib/php-sdk-7.1.3/autoload.php';
        header('Access-Control-Allow-Origin:*');
        use Qiniu\Auth;

        //use Qiniu\Storage\UploadManager;
        $accessKey = 'o3xU45XwAtrKnq3uT_4WLW9teK6AgDU3LsQEtXLt';
        $secretKey = 'ViIRuxtVK98tk2l2Zrfj-FXqN3O8ABh2qb0ZoHgn';
        $auth = new Auth($accessKey, $secretKey);
        $bucket = 'ssssdy';
        $new_name = time() . str_rand() . '.jpg';
        $policy = array(
            'saveKey' => $new_name,
            'fsizeLimit' => 2097152,//上穿图片大小最大1M
            'mimeLimit' => 'image/*',
//    'callbackUrl'=>'http://www.baidu.com/',
//    'callbackBody'=>"name=$(fname)&newname=$new_name&toid=12"
        );
        $token = $auth->uploadToken($bucket, NULL, 3600, $policy);
        ?>
        <form name="form" method="post" action="http://up-z2.qiniu.com" enctype="multipart/form-data">
            <input name="token" type="hidden" value="<?= $token ?>">
            <ul class="nav">
                <li><input name="file" type="file"/></li>
                <li><input type="submit" value="上传"/></li>
            </ul>
        </form>
    </div>
</div>
</body>
</html>