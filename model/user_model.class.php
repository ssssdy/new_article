<?php
require_once("base_mysql_model.class.php");

class User_Model{
    function check_user_exist($user_name)
    {
        $db = new Base_Mysql_Model();
        $sql = "select * from user where user_name = '$user_name'";//注意引号
        $result = mysqli_query($db->conn, $sql);
        $num = mysqli_num_rows($result);
        return $num;
    }

    function check_login($user_name, $password)
    {
        $db = new Base_Mysql_Model();
        $sql = "select user_name,password from user where user_name = '$user_name' and password = '$password'";
        $result = mysqli_query($db->conn, $sql);
        return $result;
    }

    function get_general_user_info()
    {
        $db = new Base_Mysql_Model();
        $sql = "SELECT * FROM user WHERE role_id<=1";
        $user_info = $db->fetch_all($sql);
        return $user_info;
    }

    function get_all_user_info()
    {
        $db = new Base_Mysql_Model();
        $sql = "SELECT * FROM user WHERE role_id<=2";
        $user_info = $db->fetch_all($sql);
        return $user_info;
    }

    function get_limit_user_info($set1, $set2)
    {
        $db = new Base_Mysql_Model();
        $news_info = $db->fetch_all("select * from user limit $set1,$set2");
        return $news_info;
    }

    function get_user_id($role_id)
    {
        $db = new Base_Mysql_Model();
        $sql = "select user_id from user where role_id = '$role_id'";
        $result = mysqli_query($db->conn, $sql);
        $info = mysqli_fetch_array($result);
        return $info['user_id'];
    }

    function get_role_id($user_name)
    {
        $db = new Base_Mysql_Model();
        $sql = "select role_id from user where user_name = '$user_name'";
        $result = mysqli_query($db->conn, $sql);
        $id = mysqli_fetch_array($result);
        return $id['role_id'];
    }

    function get_role_name($role_id)
    {
        $db = new Base_Mysql_Model();
        $sql = "select role_name from roles where role_id = '$role_id'";
        $result = mysqli_query($db->conn, $sql);
        $role_name = mysqli_fetch_array($result);
        return $role_name['role_name'];
    }

    function change_role($user_id, $role_id)
    {
        $db = new Base_Mysql_Model();
        $sql0 = "update user set role_id=0 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        $res = null;
        if ($role_id == 0) {
            $res1 = mysqli_query($db->conn, $sql1);
            $res = $res1;
        } elseif ($role_id == 1) {
            $res2 = mysqli_query($db->conn, $sql0);
             $res = $res2;
        }
        return $res;
    }

    function change_admin_role($user_id, $role_id)
    {
        $db = new Base_Mysql_Model();
        $sql0 = "update user set role_id=2 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        $res =null;
        if ($role_id == 2) {
            $res1 = mysqli_query($db->conn, $sql1);
            $res = $res1;
        } elseif ($role_id <= 1) {
            $res2 = mysqli_query($db->conn, $sql0);
           $res = $res2;
        }
        return $res;
    }
}