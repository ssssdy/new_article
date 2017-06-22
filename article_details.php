<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="./static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title> 文章主页 </title>

</head>
<body>
<div>
    <div class="login">
        <?php
        require './helpers/global_helper.php';
        require './model/news_model.class.php';
        require './cache/base_cache.class.php';
        check_login();
        ?>
    </div>
    <div class="menu">
        <?php
        switch ($_SESSION['role_type']) {
            case ROLE_TYPE_VISITOR:
                break;
            case ROLE_TYPE_EDITOR:
                echo "<ul><li><a href='show_news.php'>实时新闻</a></li>>;
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                break;
            case ROLE_TYPE_ADMIN:
                echo "<ul><li><a href='show_news.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                break;
            case ROLE_TYPE_SUPER:
                echo "<ul><li><a href='show_news.php'>实时新闻</a>
                        <li><a href='index.php'>文章首页</a></li>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                break;
        }
        ?>
    </div>
    <div class="content" style="position: absolute;left: 200px;top: 100px;right: 200px;height: 650px;width:1000px">
        <?php
        $news_id = $_GET['id'];
        $news_model = new News_Model();
        $redis = new Base_Cache();
        $news_status = $redis->is_exists($news_id);
        if ($news_status == 0) {
            $news_info = $news_model->get_one_news_info($news_id);
            $redis->set($news_id, json_encode($news_info), SURVIVAL_TIME_OF_NEWS);
        }
        $news_info_redis = json_decode($redis->get($news_id), true);
        $rest_survival_time = $redis->rest_survival_time($news_id);
        //        $time = gmdate("H:i:s",$rest_survival_time);
        ////        echo "缓存剩余时间:".$time."<br>";
        //        dump($news_info_redis);
        ?>
        <div style="font-size: 17px;position: absolute;right: 5px;top: 60px;">
            <?php
            echo "当前用户IP:" . $_SERVER['REMOTE_ADDR'] . "<br>";
            foreach (RATE_LIMITING_ARR as $limit => $timeout) {
                access_limit($_SERVER['REMOTE_ADDR'], $limit, $timeout);
            }
            echo "<br>";
            echo "缓存状态:";
            if ($news_status == 0) {
                echo "先存后取" . "<br>";
            } else {
                echo "直接从缓存中读取" . "<br>";
            }
            echo "缓存有效期剩余:" . seconds_to_date($rest_survival_time) . "<br>";
            //            echo "<button onclick='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</button>";
            echo "<button><a href='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</a></button>";
            ?>
        </div>
        <div>
            <span style="font-size: 25px;color: blue"><?= $news_info_redis['title'] ?></span><br/>
            <span>发布人:<?= $news_info_redis['author'] ?></span>&nbsp;
            <span>发布时间:<?= date('Y-m-d', $news_info_redis['add_time']) ?></span>&nbsp;
            <span>关键字：<span><?= $news_info_redis['keywords'] ?></span>
        </div>
        <div style="margin-top: 10px; overflow:hidden;">
            <?php echo "<td>
                <img width='600' height='300' src='" . qiniu_image_display($news_info_redis['image_url']) . "'/>
            </td>"; ?>
            <p style="text-align: left; line-height: 200%; margin-top: 0:pt; margin-bottom: 12pt; background: rgb(255,255,255)"><?= $news_info_redis['content'] ?></p>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refresh_cache(key) {
        if (confirm("确定要刷新缓存吗？")) {
            window.location = "action.php?action=refresh_cache&key=" + key;
        }
    }
</script>
</body>
</html>