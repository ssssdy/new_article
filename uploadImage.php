<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
<body>
<div class="login">
    <?php
    require './model/base_model.class.php';
    require './helpers/global_helper.php';
    check_login();
    ?>
</div>
<div class="menu">
    <?php
    switch ($_SESSION['role_type']) {
        case ROLE_TYPE_VISITOR:
            break;
        case ROLE_TYPE_EDITOR:
            echo "<ul><li><a href='showNews.php'>实时新闻</a></li>>;
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li></ul>";
            break;
        case ROLE_TYPE_ADMIN:
            echo "<ul><li><a href='showNews.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li></ul>";
            break;
        case ROLE_TYPE_SUPER:
            echo "<ul><li><a href='showNews.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='addArticle.php'>添加文章</a></li>
                        <li><a href='uploadImage.php'>图片上传</a></li>
                        <li><a href='addTag.php'>文章分类</a></li>
                        <li><a href='addEditor.php'>添加编辑</a></li>
                        <li><a href='addAdmin.php'>添加管理员</a></li></ul>";
            break;
    }
    ?>
</div>
<div class="content">
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
        <ul>
            <li><input name="file" type="file"/></li>
            <li><input type="submit" value="上传"/></li>
        </ul>
    </form>
</div>
</body>
</html>