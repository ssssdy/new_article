<?php
require_once("news_model.class.php");

class User_Model
{
    function checkUser_Exist($username)
    {
        $db1 = new News_Model();
        $sql = "select * from user where username = '$username'";//注意引号
        $result = mysqli_query($db1->conn, $sql);
        $num = mysqli_num_rows($result);
        return $num;
    }

    function checkLogin($username, $password)
    {
        $db = new News_Model();
        $sql = "select username,password from user where username = '$username' and password = '$password'";
        $result = mysqli_query($db->conn, $sql);
        return $result;
    }

    function get_GeneralUser_info()
    {
        $db = new News_Model();
        $sql = "select * from user where role_id<=1";
        $user_info = $db->fetchAll($sql);
        return $user_info;
    }

    function get_AllUser_info()
    {
        $db = new News_Model();
        $sql = "select * from user where role_id<=2";
        $user_info = $db->fetchAll($sql);
        return $user_info;
    }

    function get_LimitUser_info($set1, $set2)
    {
        $db = new News_Model();
        $news_info = $db->fetchAll("select * from user limit $set1,$set2");
        return $news_info;
    }

    function get_userId($role_id)
    {
        $db = new News_Model();
        $sql = "select user_id from user where role_id = '$role_id'";
        $result = mysqli_query($db->conn, $sql);
        $info = mysqli_fetch_array($result);
        return $info['user_id'];
    }

    function get_RoleId($username)
    {
        $db = new News_Model();
        $sql = "select role_id from user where username = '$username'";
        $result = mysqli_query($db->conn, $sql);
        $id = mysqli_fetch_array($result);
        return $id['role_id'];
    }

    function get_RoleName($role_id)
    {
        $db = new News_Model();
        $sql = "select role_name from roles where role_id = '$role_id'";
        $result = mysqli_query($db->conn, $sql);
        $role_name = mysqli_fetch_array($result);
        return $role_name['role_name'];
    }

    function chang_Role($user_id, $role_id)
    {
        $db = new News_Model();
        $sql0 = "update user set role_id=0 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        if ($role_id == 0) {
            $res = mysqli_query($db->conn, $sql1);
            return $res;
        } elseif ($role_id == 1) {
            $res1 = mysqli_query($db->conn, $sql0);
            return $res1;
        }
    }

    function changAdmin_Role($user_id, $role_id)
    {
        $db = new News_Model();
        $sql0 = "update user set role_id=2 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        if ($role_id == 2) {
            $res = mysqli_query($db->conn, $sql1);
            return $res;
        } elseif ($role_id <= 1) {
            $res1 = mysqli_query($db->conn, $sql0);
            return $res1;
        }
    }
}