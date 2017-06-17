<?php

class User_Model extends Base_Model
{
    function check_user_exist($user_name)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $sql = "select * from user where user_name='$user_name'";//注意引号
        $result = mysqli_query($this->conn, $sql);
        $num = mysqli_num_rows($result);
        return $num;
    }

    function check_login($user_name, $password)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $sql = "select user_name,password from user where user_name = '$user_name' and password = '$password'";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    function insert_user($array, $table)
    {
        return $this->insert($array, $table);
    }

    function get_general_user_info()
    {
        $sql = "SELECT * FROM user WHERE role_type<=1";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }

    function get_all_user_info()
    {
        $sql = "SELECT * FROM user WHERE role_type<=2";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }

    function get_limit_user_info($set1, $set2, $key)
    {
        $news_info = $this->fetch_all("select * from user where role_type<=$key limit $set1,$set2");
        return $news_info;
    }

    function get_user_id($role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql = "select user_id from user where role_type='$role_type'";
        $result = mysqli_query($this->conn, $sql);
        $info = mysqli_fetch_array($result);
        return $info['user_id'];
    }

    function get_role_type($user_name)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $sql = "select role_type from user where user_name = '$user_name'";
        $result = mysqli_query($this->conn, $sql);
        $id = mysqli_fetch_array($result);
        return $id['role_type'];
    }

    function get_role_type_by_user_id($user_id)
    {
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $sql = "select role_type from user where user_id = $user_id";
        $result = mysqli_query($this->conn, $sql);
        $id = mysqli_fetch_array($result);
        return $id['role_type'];
    }

    function get_role_name($role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql = "select role_name from roles where role_type=$role_type";
        $result = mysqli_query($this->conn, $sql);
        $role_name = mysqli_fetch_array($result);
        return $role_name['role_name'];
    }

    function change_role($user_id, $role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $sql0 = "update user set role_type=0 where user_id=$user_id";
        $sql1 = "update user set role_type=1 where user_id=$user_id";
        $res = null;
        if ($role_type == 0) {
            $res1 = mysqli_query($this->conn, $sql1);
            $res = $res1;
        } elseif ($role_type == 1) {
            $res2 = mysqli_query($this->conn, $sql0);
            $res = $res2;
        }
        return $res;
    }

    function change_admin_role($user_id, $role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $sql0 = "update user set role_type=2 where user_id=$user_id";
        $sql1 = "update user set role_type=1 where user_id=$user_id";
        $res = null;
        if ($role_type == 2) {
            $res1 = mysqli_query($this->conn, $sql1);
            $res = $res1;
        } elseif ($role_type <= 1) {
            $res2 = mysqli_query($this->conn, $sql0);
            $res = $res2;
        }
        return $res;
    }
}