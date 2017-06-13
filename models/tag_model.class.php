<?php
require_once ("news_model.class.php");
class Tag_Model{
    function get_one_tag_info($tagId)
    {   $db = new News_Model();
        $tag_info = $db->fetch_one("select * from tag where tag_id = $tagId");
        return $tag_info;
    }
    function get_all_tag_info()
    {   $db = new News_Model();
        $tag_info = $db->fetch_all("select * from tag");
        return $tag_info;
    }
    function delete_by_tag_id($id)
    {   $db = new News_Model();
        $sql = "DELETE FROM tag where tag_id=$id";
        mysqli_query($db->conn, $sql);
    }
}