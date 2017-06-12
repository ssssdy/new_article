<?php
require_once ("news_model.class.php");
class Tag_Model{
    function get_OneTags_info($tagId)
    {   $db = new News_Model();
        $tag_info = $db->fetchOne("select * from tag where tag_id = $tagId");
        return $tag_info;
    }

    function get_AllTags_info()
    {   $db = new News_Model();
        $tag_info = $db->fetchAll("select * from tag");
        return $tag_info;
    }
}