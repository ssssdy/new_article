<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="./lib/bootstrap_demo/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="./lib/bootstrap_demo/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="./lib/jquery/dist/jquery.min.js"></script>
    <script src="./lib/bootstrap_demo/dist/js/bootstrap.min.js"></script>
    <title> 文章管理系统 </title>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">文章系统</a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">下拉菜单<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">jmeter</a></li>
                        <li><a href="#">EJB</a></li>
                        <li><a href="#">Jasper Report</a></li>
                        <li class="divider"></li>
                        <li><a href="#">分离的链接</a></li>
                        <li class="divider"></li>
                        <li><a href="#">另一个分离的链接</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                require './helpers/global_helper.php';
                require './model/news_model.class.php';
                require './model/user_model.class.php';
                require './model/tag_model.class.php';
                require './model/news_comment_model.class.php';
                require './model/zan_news.class.php';
                require './cache/user_access_times_cache.php';
                require './cache/news_details_cache.php';
                check_login();
                ?>
            </ul>
        </div>
    </div>
</nav
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php
            switch ($_SESSION['role_type']) {
                case ROLE_TYPE_VISITOR:
                    break;
                case ROLE_TYPE_EDITOR:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a></li>>;
                        <li><a href='add_article.php'>添加文章</a></li></ul>";
                    break;
                case ROLE_TYPE_ADMIN:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li></ul>";
                    break;
                case ROLE_TYPE_SUPER:
                    echo "<ul class=\"nav nav-tabs nav-stacked\">
                        <li><a href='show_news.php'>实时新闻</a>
                        <li><a href='add_article.php'>添加文章</a></li>
                        <li><a href='upload_image.php'>图片上传</a></li>
                        <li><a href='add_tag.php'>文章分类</a></li>
                        <li><a href='add_editor.php'>添加编辑</a></li>
                        <li><a href='add_admin.php'>添加管理员</a></li></ul>";
                    break;
            }
            ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-10 table-responsive">
            <div class="container-fluid">
                <div class="row">
                    <div style="float: right;border: 1px solid #000;" class="col-md-4">
                        <?php
                        $redis = new Access_Times_Cache();
                        $news_details_cache = new News_Details_Cache();
                        echo "当前用户IP:" . $_SERVER['REMOTE_ADDR'] . "<br>";
                        foreach (RATE_LIMITING_ARR as $limit => $timeout) {
                            $redis->access_limit($_SERVER['REMOTE_ADDR'], $limit, $timeout);
                        }
                        $count = $redis->increase_access_time($_SERVER['REMOTE_ADDR']);
                        echo $_SERVER['REMOTE_ADDR'] . "的访问次数:" . $count . "<br/>";
                        $news_id = $_GET['id'];
                        $_SESSION['news_id'] = $news_id;
                        echo "缓存状态: ";
                        $news_info_redis = $news_details_cache->show_news_details($news_id);
                        echo "<br>";
                        $rest_survival_time = $news_details_cache->rest_survival_time($news_id);
                        echo "缓存有效期剩余:" . seconds_to_date($rest_survival_time) . "<br>";
                        //            echo "<button onclick='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</button>";
                        echo "<button><a href='javascript:refresh_cache({$news_info_redis['id']})'>刷新缓存</a></button><br/>";
                        ?>
                    </div>
                    <div class="col-md-8">
                        <h2><b><span><?= $news_info_redis['title'] ?></span></b></h2>
                        <p style="font-size: 16px"><span>发布人:<?= $news_info_redis['author'] ?></span>&nbsp;
                            <span>发布时间:<?= date('Y-m-d', $news_info_redis['add_time']) ?></span>&nbsp;
                            <span>关键字：<span><?= $news_info_redis['keywords'] ?></span></span></p>
                        <?php echo "<td><img width='600' height='300' class='img-responsive' alt='响应式图像' src='" . qiniu_image_display($news_info_redis['image_url']) . "'/></td>"; ?>
                        <p style="font-size: 17px"><?= $news_info_redis['content'] ?></p>
                        <button onclick="a();" id="good">
                            <?php
                            //判断cookie是否设置，如果设置输出已赞，如果没有输出赞一个
                            $zan_model = new Zan_News_Model();
                            $num = $zan_model->zan_num_of_news($news_id);
                            if(isset($_COOKIE['good'])){
                                echo "已赞";
                            }else{
                                echo "赞一个";
                            }?>
                        </button>(<span id="num_zan"><?=$num?></span>)<span style="color: red" id="zan_message"></span>
<!--                        文章评论-->
                        <div id="post">
                            <input id="news_id" type="hidden" name="news_id" value="<?= $news_id ?>"/>
                            <input id="user_id" type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>"/>
                            <input id="user_name" type="hidden" name="user_name" value="<?= $_SESSION['user_name'] ?>"/>
                            <p>发表评论</p>
                            <div style="float: right;color: red" id="message"></div>
                            <textarea id="txt" name="comment_text" class="form-control" rows="3" title=""></textarea>
                            <p class="text-right"><input class="btn btn-success" id="add" type="submit" value="提交"/></p>
                        </div>
                        <div id="comments">
                            <h4>评论列表</h4>
                            <?php
                            $news_comment_model = new News_comment_Model();
                            $comments = $news_comment_model->get_comment($news_id);
                            foreach ($comments as $news_comment) {
                                echo "<dl>";
                                echo "<dt class='comment_head'><span class='user_name'>昵称:" . $news_comment['user_name'] . "</span>  <span>评论时间:" . $news_comment['create_time'] . "</span></dt>";
                                echo "<dt class='comment_body'>" . $news_comment['comment'] . "</dt>";
                                echo "</dl>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function refresh_cache(key) {
                if (confirm("确定要刷新缓存吗？")) {
                    window.location = "action.php?action=refresh_cache&key=" + key;
                }
            }
            //            $(document).ready(function(){
            //                var comments = $("#comments");
            //                $.getJSON("action.php?action=get_comment",function(json){
            //                    $.each(json,function(index,array){
            //                        var txt = "<p><strong>昵称"+array["user_name"]+"</strong>："+array["comment"]+"<span>"
            //                            +array["create_time"]+"</span></p>";
            //                        comments.append(txt);
            //                    });
            //                });
            //            });
//            文章评论
            $("#add").click(function () {
                var user_id = $("#user_id").val();
                var user_name = $("#user_name").val();
                var news_id = $("#news_id").val();
                var txt = $("#txt").val();
                var comments = $("#comments");
                $.ajax({
                    type: "POST",
                    url: "action.php?action=add_comment",
                    data: "user_id=" + user_id + "&txt=" + txt + "&news_id=" + news_id + "&user_name=" + user_name,
                    success: function (msg) {
                        var str = "<dl><dt class='comment_head'><span class='user_name'>" + user_name + "<span>刚刚评论说:</span>" + txt + "</dt><dl>";
                        comments.append(str);
                        $("#message").show().html(msg).fadeOut(1000);
//                        $("#txt").attr("value", "");
                    }
                });
            });
//            点赞
            $("#good").click(function () {
                var user_id = $("#user_id").val();
                var user_name = $("#user_name").val();
                var news_id = $("#news_id").val();
                var num = $("#num_zan").val();
                var new_num = num+1;
                $.ajax({
                    type: "POST",
                    url: "action.php?action=add_zan",
                    data: "user_id=" + user_id + "&num=" + num + "&news_id=" + news_id + "&user_name=" + user_name,
                    success: function (msg) {
                        $("#zan_message").show().html(msg).fadeOut(1000);
                    }
                });
            });
        </script>
</body>
</html>