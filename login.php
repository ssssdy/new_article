<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <link href="/static/css/style.css" rel="stylesheet" type="text/css">
    <title>用户登陆界面</title>
<!--    点击验证码刷新-->
    <script language="javascript">
        function newgdcode(obj,url) {
            obj.src = url+ '?now_time=' + new Date().getTime();
        }
    </script>
    <style type="text/css">
        code{
            width:80px;
        }
        /*.title{*/
            /*font-weight: bold;*/
            /*font-size: 20px;*/
            /*position: relative;*/
            /*left: 50px;*/
        /*}*/
        /*.bd{*/
            /*background-color: aqua;*/
            /*width: 230px;*/
        /*}*/
    </style>
</head>
<body>
<center>
    <h3 class="title">用户登录</h3>
    <form action="action.php?action=logincheck" method="post">
        <table class="bd">
            <tr>
                <td>用户名：</td>
                <td><input type="text" name="username" placeholder="请输入用户名"/></td>
            </tr>
            <br/>
            <tr>
                <td align="right">密码：</td>
                <td><input type="password" name="password" placeholder="请输入密码"/></td>
            </tr>
            <br/>
            <tr>
                <td>验证码：</td>
                <td><input type="text" name="code" placeholder="请输入验证码"/></td>
                <td>
                    <img src="../erWeiMa.php" alt="看不清楚，换一张" onclick="javascript:newgdcode(this,this.src)"/>
                </td>
            </tr>
            <br/>
            <tr>
                <td align="center"><input type="submit" name="submit" value="登录"/></td>
                <td align="center"><a href="register.php">立即注册</a></td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>