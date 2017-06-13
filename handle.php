<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
</head>
<div class="login">
        <?php
        require_once './models/news_model.class.php';
        require_once './models/tag_model.class.php';
        require_once './helpers/global_helper.php';
        require './models/user_model.class.php';
        check_login();
        ?>
</div>
<?php
require_once './lib/php-sdk-7.1.3/autoload.php';
header('Access-Control-Allow-Origin:*');
use Qiniu\Auth;
//use Qiniu\Storage\UploadManager;

$accessKey = 'o3xU45XwAtrKnq3uT_4WLW9teK6AgDU3LsQEtXLt';
$secretKey = 'ViIRuxtVK98tk2l2Zrfj-FXqN3O8ABh2qb0ZoHgn';
$auth = new Auth($accessKey, $secretKey);
$bucket = 'ssssdy';
$newname = time().'.jpg';
$policy = array(
    'saveKey'=>$newname,
);
$token = $auth->uploadToken($bucket,NULL, 3600, $policy);
?>
<form method="post" action="http://up-z2.qiniu.com" enctype="multipart/form-data">
    <input name="token" type="hidden" value="<?php echo $token;?>">
    <input name="file" type="file" />
    <input type="submit" value="上传"/>
</form>
</html>