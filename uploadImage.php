<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">

<body>
<div class="login">
    <?php
    require './model/news_model.class.php';
    require './model/tag_model.class.php';
    require './helpers/global_helper.php';
    require './model/user_model.class.php';
    check_login();
    ?>
</div>
<?php
require './lib/php-sdk-7.1.3/autoload.php';
header('Access-Control-Allow-Origin:*');
use Qiniu\Auth;

//use Qiniu\Storage\UploadManager;

//$file = $_FILES['file']['tmp_name'];
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
//$uploadMgr = New UploadManager();
//list($ret, $err) = $uploadMgr->putFile($token, null, $file);
//echo "\n====> putFile result: \n";if ($err !== null) {
//    var_dump($err);
//} else {
//    var_dump($ret);
//}
?>
<form name="form" method="post" action="http://up-z2.qiniu.com" enctype="multipart/form-data">
    <input name="token" type="hidden" value="<?= $token ?>">
    <ul>
        <!--        <li>-->
        <!--            <label for="key">name:</label>-->
        <!--            <input name="key" value=""/>-->
        <!--        </li>-->
        <li><input name="file" type="file"/></li>
        <li><input type="submit" value="上传"/></li>
    </ul>
</form>
<!--<script>-->
<!--    function check_file(obj) {-->
<!--        var file_size_limit =1048576;-->
<!--        var extend = document.form.file.value.substring(document.form.file.value.lastIndexOf(".") + 1);-->
<!--        if (extend == "") {-->
<!--            alert("请选择图片!");-->
<!--            return false;-->
<!--        }-->
<!--        else {-->
<!--            if (!(extend == "jpg" || extend == "png" || extend == "gif")) {-->
<!--                alert("请上传后缀名为jpg或png或gif的图片!");-->
<!--                return false;-->
<!--            }-->
<!--        }else{-->
<!--            if(){}-->
<!--        }-->
<!--        return true;-->
<!--    }-->
<!--</script>-->
</body>
</html>