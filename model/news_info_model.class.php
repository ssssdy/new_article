<?php
include("base_mysql_model.class.php");
class Real_Time_News_Model{
    function insert_real_time_news($array){
        $db = new Base_Mysql_Model();
        $sql = "insert into real_news (id,content) VALUES (null,'{$array}')";
        $res = mysqli_query($db->conn, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    function get_real_time_news()
    {
        $db = new Base_Mysql_Model();
        $real_news_info = $db->fetch_all("SELECT *FROM real_news");
        return $real_news_info;
    }
    function get_limit_real_news($set1, $set2)
    {
        $db = new Base_Mysql_Model();
        $real_news_info = $db->fetch_all("select * from real_news limit $set1,$set2");
        return $real_news_info;
    }
}