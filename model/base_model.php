<?php
define("HOST", "localhost");
define("USER", "root");
define("PASS", "15827398906");
define("DB_NAME", "newsdb");
define("DB_CHARSET", "utf8");

class Base_Model
{
    public $host_name = HOST;
    public $user_name = USER;
    public $password = PASS;
    public $db_name = DB_NAME;
    public $db_charset = DB_CHARSET;
    public $conn;

    function __construct()
    {
        $config = mysqli_connect($this->host_name, $this->user_name, $this->password);
        if (!$config) {
            echo "数据库连接失败!";
            exit;
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $this->db_name);
        if (!$res) {
            echo "数据库连接失败!";
            exit;
        }
        mysqli_set_charset($config, $this->db_charset);
    }

    function __destruct()
    {
        mysqli_close($this->conn);
    }

    function fetch_one($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if (!empty($result)) {
            $data = mysqli_fetch_array($result);
        }
        return $data;
    }

    function fetch_all($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;                             //注意此处与fetch_one不同，为二位数组
            }
        }
        return $data;
    }

    function insert($array, $table)
    {
        $keys = join(',', array_keys($array));
        $values = "'" . join("','", array_values($array)) . "'";
        $sql = "insert into {$table}({$keys}) VALUES ({$values})";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function update_by_id($table, $arr, $id)
    {
        foreach ($arr as $key => $value) {
            $value = mysqli_real_escape_string($this->conn, $value);
            $keyAndvalueArr[] = $key . "='" . $value . "'";        //合成类似：var = 'var1'var2='var3'这样的字符串
        }
        $keyAndvalues = join(',', $keyAndvalueArr);           //将字符串用','隔开,变成：var = 'var1',var2='var3'
        $sql = "update {$table} set {$keyAndvalues} where id={$id}";//修改操作 格式 update 表名 set 字段=值 where 条件
        mysqli_query($this->conn, $sql);
    }

    function delete($table, $where = null)
    {
        $where = $where == null ? '' : ' WHERE ' . $where;
        $sql = "DELETE FROM {$table}{$where}";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }
}

class Base_News_model extends Base_Model
{
    function insert_news($array, $table)
    {
        return $this->insert($array, $table);
    }

    function update_news($table, $arr, $id)
    {
        $this->update_by_id($table, $arr, $id);
    }

    function get_one_news_info($news_id)
    {
        $news_info = $this->fetch_one("select * from news where id = $news_id");
        return $news_info;
    }

    function get_limit_news_info($set1, $set2)
    {
        $news_info = $this->fetch_all("select * from news limit $set1,$set2");
        return $news_info;
    }

    function get_all_news_info()
    {
        $news_info = $this->fetch_all("SELECT *FROM news");
        return $news_info;
    }

    function delete_by_id($id)
    {
        $sql = "DELETE FROM news where id=$id";
        mysqli_query($this->conn, $sql);
    }

}

class Base_User_Model extends Base_Model
{
    function check_user_exist($user_name)
    {
        $sql = "select * from user where user_name = '$user_name'";//注意引号
        $result = mysqli_query($this->conn, $sql);
        $num = mysqli_num_rows($result);
        return $num;
    }

    function check_login($user_name, $password)
    {
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
        $sql = "SELECT * FROM user WHERE role_id<=1";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }

    function get_all_user_info()
    {
        $sql = "SELECT * FROM user WHERE role_id<=2";
        $user_info = $this->fetch_all($sql);
        return $user_info;
    }

    function get_limit_user_info($set1, $set2, $key)
    {
        $news_info = $this->fetch_all("select * from user where role_id<=$key limit $set1,$set2");
        return $news_info;
    }

    function get_user_id($role_id)
    {
        $sql = "select user_id from user where role_id = '$role_id'";
        $result = mysqli_query($this->conn, $sql);
        $info = mysqli_fetch_array($result);
        return $info['user_id'];
    }

    function get_role_id($user_name)
    {
        $sql = "select role_id from user where user_name = '$user_name'";
        $result = mysqli_query($this->conn, $sql);
        $id = mysqli_fetch_array($result);
        return $id['role_id'];
    }

    function get_role_name($role_id)
    {
        $sql = "select role_name from roles where role_id = '$role_id'";
        $result = mysqli_query($this->conn, $sql);
        $role_name = mysqli_fetch_array($result);
        return $role_name['role_name'];
    }

    function change_role($user_id, $role_id)
    {
        $sql0 = "update user set role_id=0 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        $res = null;
        if ($role_id == 0) {
            $res1 = mysqli_query($this->conn, $sql1);
            $res = $res1;
        } elseif ($role_id == 1) {
            $res2 = mysqli_query($this->conn, $sql0);
            $res = $res2;
        }
        return $res;
    }

    function change_admin_role($user_id, $role_id)
    {
        $sql0 = "update user set role_id=2 where user_id=$user_id";
        $sql1 = "update user set role_id=1 where user_id=$user_id";
        $res = null;
        if ($role_id == 2) {
            $res1 = mysqli_query($this->conn, $sql1);
            $res = $res1;
        } elseif ($role_id <= 1) {
            $res2 = mysqli_query($this->conn, $sql0);
            $res = $res2;
        }
        return $res;
    }
}

class Base_Tag_Model extends Base_Model
{
    function get_one_tag_info($tagId)
    {
        $tag_info = $this->fetch_one("select * from tag where tag_id = $tagId");
        return $tag_info;
    }

    function get_all_tag_info()
    {
        $tag_info = $this->fetch_all("SELECT * FROM tag");
        return $tag_info;
    }

    function delete_by_tag_id($id)
    {
        $sql = "DELETE FROM tag where tag_id=$id";
        mysqli_query($this->conn, $sql);
    }

    function insert_tag($array, $table)
    {

        return $this->insert($array, $table);
    }
}

class Base_Real_News_Model extends Base_Model
{
    function insert_real_time_news($array)
    {
        $sql = "insert into real_news (id,content) VALUES (null,'{$array}')";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function get_real_time_news()
    {
        $real_news_info = $this->fetch_all("SELECT *FROM real_news");
        return $real_news_info;
    }

    function get_limit_real_news($set1, $set2)
    {
        $real_news_info = $this->fetch_all("select * from real_news limit $set1,$set2");
        return $real_news_info;
    }

    function get_one_real_news_($real_news_id)
    {
        $news_info = $this->fetch_one("select content from real_news where id = $real_news_id");
        return $news_info;
    }
}
