<html>
<head>
    <meta charset="utf-8">
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
</head>
<?php
require './helpers/global_helper.php';
require './model/news_model.class.php';
require './model/user_model.class.php';
require './model/tag_model.class.php';
require './cache/base_cache.class.php';
$news_model = new News_model();
$tag_model = new Tag_Model();
$user_model = new User_Model();
switch ($_GET["action"]) {
    case "add":
        $tag_id = $_POST["tag_id"];
        $title = $_POST["title"];
        $keywords = $_POST["keywords"];
        $author = $_POST["author"];
        $content = $_POST["content"];
        $image_url = $_POST["image_url"];
        $add_time = time();
        if ($title == null) {
            echo "<script>alert('标题不能为空!'); window.location.href='add_article.php';</script>";
            exit;
        }
        $arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
            'content' => $content, 'image_url' => $image_url, 'add_time' => $add_time);
        $res = $news_model->insert_news($arr, 'news');
        if ($res) {
            echo "<script>alert('添加成功！返回首页浏览'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('添加失败！'); history.go(-1);</script>";
        }
        break;
    case "delete_news":
        $id = $_GET['id'];
        $news_model->delete_by_news_id($id);
        $news_info = $news_model->get_one_news_info($id);
        header("Location:index.php");
        break;
    case "refresh_cache":
        $key = $_GET['key'];
        $redis = new Base_Cache();
        $redis->delete($key);
        header("Location:article_details.php?id=$key");
        break;
    case "switch_city":
        $city_name = $_POST['city_name'];
        $city_id = area_to_id($city_name);
        if ($city_id == null) {
            exit('您输入的城市不存在!');
        }
        $weather_info = get_real_weather_info($city_id);
        header("Location:show_weather_info.php");
        break;
    case "add_tag":
        $tag_name = $_POST['tag_name'];
        if ($tag_name == null) {
            echo "<script>alert('不能添加空类别!'); window.location.href='add_tag.php';</script>";
            exit;
        }
        $res = $tag_model->insert_tag(array('tag_name' => $tag_name), 'tag');
        if ($res) {
            echo "<script>alert('添加成功！返回'); window.location.href='add_tag.php';</script>";
        } else {
            echo "<script>alert('添加失败！'); history.go(-1);</script>";
        }
        break;
    case "delete_tag":
        $tag_id = $_GET['tag_id'];
        $tag_model->delete_by_tag_id($tag_id);
        header("Location:add_tag.php");
        break;
    case "update":
        $tag_id = $_POST['tag_id'];
        $title = $_POST['title'];
        $keywords = $_POST['keywords'];
        $author = $_POST['author'];
        $content = $_POST['content'];
        $image_url = $_POST['image_url'];
        $id = $_POST['id'];
        echo $id;
        $arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
            'content' => $content, 'image_url' => $image_url);
        $news_model->update_news('news', $arr, $id);
        header("Location:index.php");
        break;
    case "logout":
        session_start();
        unset($_SESSION['user_name']);
        unset($_SESSION['role_type']);
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
                        $user_info = array('user_name' => $user, 'password' => $psw, 'phone' => $phone, 'address' => $address);
                        $result = $user_model->insert_user($user_info, 'user');
                        if ($result) {
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
        if (isset($_POST["submit"])) {
            $user = $_POST["user_name"];
            $psw = $_POST["password"];
            $code = $_POST["code"];
            if ($user == "" || $psw == "") {
                echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";
            } else {
                $result = $user_model->check_login($user, $psw);
                $num = mysqli_num_rows($result);
                if ($code == null) {
                    echo "<script>alert('验证码不能为空！');window.location.href='login.php'</script>";
                } else if ($_SESSION['rand'] != $code) {
                    echo "<script>alert('验证码错误！请重新填写');window.location.href='login.php'</script>";
                } else if ($num) {
                    $check_user_info = mysqli_fetch_array($result);
                    $_SESSION['user_name'] = $check_user_info['user_name'];
                    $role_type = $user_model->get_role_type($check_user_info['user_name']);
                    $_SESSION['role_type'] = $role_type;
                    $_SESSION['role_name'] = $user_model->get_role_name($role_type);
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
    case "change_editor":
        $user_id = $_GET['id'];
        $role_type = $user_model->get_role_type_by_user_id($user_id);
        $result = $user_model->change_role($user_id, $role_type);
        header("Location:add_editor.php");
        break;
    case "change_admin":
        $user_id = $_GET['id'];
        $role_type = $user_model->get_role_type_by_user_id($user_id);
        $result = $user_model->change_admin_role($user_id, $role_type);
        header("Location:add_admin.php");
        break;
}
?>
</html>
