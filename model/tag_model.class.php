<?php
class Tag_Model extends Base_Model
{
    function get_one_tag_info($tag_id)
    {
        $tag_id = mysqli_real_escape_string($this->conn, $tag_id);
        $tag_info = $this->fetch_one("select * from tag where tag_id = $tag_id");
        return $tag_info;
    }

    function get_all_tag_info()
    {
        $tag_info = $this->fetch_all("SELECT * FROM tag");
        return $tag_info;
    }

    function delete_by_tag_id($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM tag where tag_id=$id";
        mysqli_query($this->conn, $sql);
    }

    function insert_tag($array, $table)
    {
        return $this->insert($array, $table);
    }
}