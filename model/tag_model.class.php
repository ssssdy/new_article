<?php
require_once ("base_mysql_model.class.php");
class Tag_Model{
    function get_one_tag_info($tagId)
    {   $db = new Base_Mysql_Model();
        $tag_info = $db->fetch_one("select * from tag where tag_id = $tagId");
        return $tag_info;
    }
    function get_all_tag_info()
    {   $db = new Base_Mysql_Model();
        $tag_info = $db->fetch_all("select * from tag");
        return $tag_info;
    }
    function delete_by_tag_id($id)
    {   $db = new Base_Mysql_Model();
        $sql = "DELETE FROM tag where tag_id=$id";
        mysqli_query($db->conn, $sql);
    }
}