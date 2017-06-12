<html>
<head>
    <link href="../static/css/style.css" rel="stylesheet" type="text/css">
</head>
<?php
echo("<meta charset = 'utf-8'>");
require("../static/dbconfig.php");
require '../models/news_model.class.php';
require '../models/tag_model.class.php';
require '../models/user_model.class.php';
include("../static/globle_helper.php");
$link = new News_Model();
$link3 = new User_Model();
switch ($_GET["action"]) {
    case "add":
        $tag_id = $_POST["tag_id"];
        $title = $_POST["title"];
        $keywords = $_POST["keywords"];
        $author = $_POST["author"];
        $content = $_POST["content"];
        $image_name = $_POST["image_name"];
        $addtime = time();
        $arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
            'content' => $content, 'image_name' => $image_name, 'addtime' => $addtime);
        $link->insert($arr, 'news');
        echo "<a href='javascript:window.history.back();'>返回</a>";
        echo "<a href='../views/index.php'>浏览文章！</a>";
        break;
    case "del":
        $id = $_GET['id'];
        dump($id);
        $link->delete_ById($id);
        header("Location:../views/index.php");
        break;
//    case "add_tag":
//
//        break;
    case "update":
        $tag_id = $_POST['tag_id'];
        $title = $_POST['title'];
        $keywords = $_POST['keywords'];
        $author = $_POST['author'];
        $content = $_POST['content'];
        $image_name = $_POST['image_name'];
        $id = $_POST['id'];
        echo $id;
        $arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
            'content' => $content, 'image_name' => $image_name);
        $link->update_ById('news', $arr, $id);
        header("Location:../views/index.php");
        break;
    case "logout":
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role_id']);
        echo "退出登录成功！点击此处<a href='../views/login.php'> 登录</a><a href='../views/index.php'> 返回主页</a>";
        break;
//    case "upload_image":
//        $dir = './upload_images/';
//        $file = $_FILES['uploadfile'];
//        $name = $file['name'];
//        $type = strtolower(substr($name, strrpos($name, '.') + 1));
//        $allow_type = array('jpg', 'jpeg', 'gif', 'png');
//        if (!in_array($type, $allow_type)) {
//            return;
//        }
//        if (!is_uploaded_file($file['tmp_name'])) {
//            return;
//        }
//        if (move_uploaded_file($file['tmp_name'], $dir . $file['name'])) {
//            echo "上传成功！";
//        } else {
//            echo "Failed!";
//        }
//        echo "<a href='javascript:window.history.back();'>返回  </a>";
//        echo "<a href='../views/index.php'>浏览文章！</a>";
//        break;
    case "regCheck":
        if (isset($_POST["submit"])) {
            $user = $_POST["username"];
            $psw = $_POST["password"];
            $psw_confirm = $_POST["confirm"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            if ($user == "" || $psw == "" || $psw_confirm == "") {
                echo "<script>alert('请确认信息完整性！'); history.go(-1);</script>";
            } else {
                if ($psw == $psw_confirm) {
                    $num = $link3->checkUser_Exist($user);
                    if ($num > 0) {
                        echo "<script>alert('用户名已存在！');history.back()</script>";
                    } else {
                        $arr1 = array('username' => $user, 'password' => $psw, 'phone' => $phone, 'address' => $address);
                        $rs = $link->insert($arr1, 'user');
                        if ($rs) {
                            echo "<script>alert('注册成功！请登录')</script>";
                            header("refresh:0;url='../views/login.php'");
                        }
                    }
                } else {
                    echo "<script>alert('密码不一致！'); history.go(-1);</script>";
                }
            }
        } else {
            echo "<script>alert('提交未成功！'); history.go(-1);</script>";
        }
        break;
    case "logincheck":
        session_start();
        $link1 = new User_Model();
        if (isset($_POST["submit"])) {
            $user = $_POST["username"];
            $psw = $_POST["password"];
            $code = $_POST["code"];
            if ($user == "" || $psw == "") {
                echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";
            } else {
                $result = $link1->checkLogin($user,$psw);
                $num = mysqli_num_rows($result);
                if($code==null){
                    echo "<script>alert('验证码不能为空！');window.location.href='../views/login.php'</script>";
                }
                else if ($_SESSION['rand'] != $code) {
                    echo "<script>alert('验证码错误！请重新填写');window.location.href='../views/login.php'</script>";
                } else if ($num) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['username'] = $row['username'];
                    $role_id = $link1->get_RoleId($row['username']);
                    $_SESSION['role_id'] = $role_id;
                    $_SESSION['role_name'] = $link1->get_RoleName($role_id);
                    header("refresh:0;url=../views/index.php");
                } else {
                    echo "<script>alert('用户名或密码不正确！');window.location.href='../views/login.php';</script>";
                }
            }
        } else {
            echo "提交未成功！";
            echo "<script> history.go(-1);</script>";
        }
        break;
    case "changeRole1":
        $role_id = $_GET['id'];
        $user_id = $link3->get_userId($role_id);
        $result = $link3->chang_Role($user_id,$role_id);
        if($result){
            echo "<script>alert('用户权限已变更！'); history.go(-1);</script>";}
        break;
    case "changeRole2":
        $role_id = $_GET['id'];
        $user_id = $link3->get_userId($role_id);
        $result = $link3->changAdmin_Role($user_id,$role_id);
        if($result){
            echo "<script>alert('用户权限已变更！'); history.go(-1);</script>";}
        break;
}
?>
</html>
