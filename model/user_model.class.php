<?php

require_once 'base_model.class.php';

class User_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_user_exist($user_name)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $sql = "select * from user where user_name='$user_name'";//注意引号
        $result = $this->query($sql);
        $num = mysqli_num_rows($result);
        return $num;
    }

    function check_login($user_name, $password)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $sql = "select user_name,password from user where user_name = '$user_name' and password = '$password'";
        $result = $this->query($sql);
        return $result;
    }

    function insert_user($array, $table)
    {
        return $this->insert($array, $table);
    }

    function get_general_user_info($type)
    {
        $sql = "SELECT * FROM user WHERE role_type<=$type";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }

    function get_all_user_info($type)
    {
        $sql = "SELECT * FROM user WHERE role_type<=$type";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }


    function get_limit_user_info($start, $end, $type)
    {
        $news_info = $this->fetch_all("select * from user where role_type<=$type limit $start,$end");
        return $news_info;
    }

    function get_user_id($role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql = "select user_id from user where role_type='$role_type'";
        $result = $this->query($sql);
        $info = mysqli_fetch_array($result);
        return $info['user_id'];
    }

    function get_role_type($user_name)
    {
        $user_name = mysqli_real_escape_string($this->conn, $user_name);
        $sql = "select role_type from user where user_name = '$user_name'";
        $result = $this->query($sql);
        $id = mysqli_fetch_array($result);
        return $id['role_type'];
    }

    function get_role_type_by_user_id($user_id)
    {
        $sql = "select role_type from user where user_id = $user_id";
        $result = $this->query($sql);
        $id = mysqli_fetch_array($result);
        return $id['role_type'];
    }

    function get_role_name($role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql = "select role_name from roles where role_type=$role_type";
        $result = $this->query($sql);
        $role_name = mysqli_fetch_array($result);
        return $role_name['role_name'];
    }

    function change_role($user_id, $role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql_down = "update user set role_type=" . ROLE_TYPE_VISITOR . " where user_id=$user_id";
        $sql_up = "update user set role_type=" . ROLE_TYPE_EDITOR . " where user_id=$user_id";
        $result = null;
        if ($role_type == ROLE_TYPE_VISITOR) {
            $res_up = $this->query($sql_up);
            $result = $res_up;
        } elseif ($role_type == ROLE_TYPE_EDITOR) {
            $res_down = $this->query($sql_down);
            $result = $res_down;
        }
        return $result;
    }

    function change_admin_role($user_id, $role_type)
    {
        $role_type = mysqli_real_escape_string($this->conn, $role_type);
        $sql_up = "update user set role_type=" . ROLE_TYPE_ADMIN . " where user_id=$user_id";
        $sql_down = "update user set role_type=" . ROLE_TYPE_EDITOR . " where user_id=$user_id";
        $result = null;
        if ($role_type == ROLE_TYPE_ADMIN) {
            $res_down = $this->query($sql_down);
            $result = $res_down;
        } elseif ($role_type <= ROLE_TYPE_EDITOR) {
            $res_up = $this->query($sql_up);
            $result = $res_up;
        }
        return $result;
    }
}