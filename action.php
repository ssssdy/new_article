<html>
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
</head>
<?php
echo("<meta charset = 'utf-8'>");
require './model/news_model.class.php';
require './model/tag_model.class.php';
require './model/user_model.class.php';
include("./helpers/global_helper.php");
$news_model = new News_Model();
$tag_model = new Tag_Model();
$user_model = new User_Model();
switch ($_GET["action"]) {
    case "add":
        $tag_id = $_POST["tag_id"];
        $title = $_POST["title"];
        $keywords = $_POST["keywords"];
        $author = $_POST["author"];
        $content = $_POST["content"];
        $image_name = $_POST["image_name"];
        $add_time = time();
        $arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
            'content' => $content, 'image_name' => $image_name, 'add_time' => $add_time);
        $res = $news_model->insert($arr, 'news');
        if ($res) {
            echo "<script>alert('添加成功！返回首页浏览'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('添加失败！'); history.go(-1);</script>";
        }
        break;
    case "delete_news":
        $id = $_GET['id'];
        dump($id);
        $news_model->delete_by_id($id);
        header("Location:index.php");
        break;
    case "add_tag":
        $tag_name = $_POST['tag_name'];
        $res = $news_model->insert(array('tag_name' => $tag_name), 'tag');
        if ($res) {
            echo "<script>alert('添加成功！返回'); window.location.href='addTag.php';</script>";
        } else {
            echo "<script>alert('添加失败！'); history.go(-1);</script>";
        }
        break;
    case "delete_tag":
        $tag_id = $_GET['tag_id'];
        $tag_model->delete_by_tag_id($tag_id);
        header("Location:addTag.php");
        break;
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
        $news_model->update_by_id('news', $arr, $id);
        header("Location:index.php");
        break;
    case "logout":
        session_start();
        unset($_SESSION['user_name']);
        unset($_SESSION['role_id']);
        echo "退出登录成功！点击此处<a href='login.php'> 登录</a><a href='index.php'> 返回主页</a>";
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
//        echo "<a href='index.php'>浏览文章！</a>";
//        break;
    case "register_check":
        if (isset($_POST["submit"])) {
            $user = $_POST["user_name"];
            $psw = $_POST["password"];
            $psw_confirm = $_POST["confirm"];
            $phone = $_POST["phone"];
            $address = $_POST["address"];
            if ($user == "" || $psw == "" || $psw_confirm == "") {
                echo "<script>alert('请确认信息完整性！'); history.go(-1);</script>";
            } else {
                if ($psw == $psw_confirm) {
                    $num = $user_model->check_user_exist($user);
                    if ($num > 0) {
                        echo "<script>alert('用户名已存在！');history.back()</script>";
                    } else {
                        $arr1 = array('user_name' => $user, 'password' => $psw, 'phone' => $phone, 'address' => $address);
                        $rs = $news_model->insert($arr1, 'user');
                        if ($rs) {
                            echo "<script>alert('注册成功！请登录')</script>";
                            header("refresh:0;url='login.php'");
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
    case "login_check":
        session_start();
        $news_model1 = new User_Model();
        if (isset($_POST["submit"])) {
            $user = $_POST["user_name"];
            $psw = $_POST["password"];
            $code = $_POST["code"];
            if ($user == "" || $psw == "") {
                echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";
            } else {
                $result = $news_model1->check_login($user, $psw);
                $num = mysqli_num_rows($result);
                if ($code == null) {
                    echo "<script>alert('验证码不能为空！');window.location.href='login.php'</script>";
                } else if ($_SESSION['rand'] != $code) {
                    echo "<script>alert('验证码错误！请重新填写');window.location.href='login.php'</script>";
                } else if ($num) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['user_name'] = $row['user_name'];
                    $role_id = $news_model1->get_role_id($row['user_name']);
                    $_SESSION['role_id'] = $role_id;
                    $_SESSION['role_name'] = $news_model1->get_role_name($role_id);
                    header("refresh:0;url=index.php");
                } else {
                    echo "<script>alert('用户名或密码不正确！');window.location.href='login.php';</script>";
                }
            }
        } else {
            echo "提交未成功！";
            echo "<script> history.go(-1);</script>";
        }
        break;
    case "change_role1":
        $role_id = $_GET['id'];
        $user_id = $user_model->get_user_id($role_id);
        $result = $user_model->change_role($user_id, $role_id);
        if ($result) {
            echo "<script>alert('用户权限已变更！'); history.go(-1);</script>";
        }
        break;
    case "change_role2":
        $role_id = $_GET['id'];
        $user_id = $user_model->get_user_id($role_id);
        $result = $user_model->change_admin_role($user_id, $role_id);
        if ($result) {
            echo "<script>alert('用户权限已变更！'); history.go(-1);</script>";
        }
        break;
}
?>
</html>
