<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <link href="./static/css/style.css" rel="stylesheet" type="text/css">
    <title>用户登陆界面</title>
</head>
<body>
    <form action="action.php?action=login_check" method="post">
        <table align="center">
            <caption style="font-size: 22px">用户登录</caption>
            <tr>
                <td align="center">用户名：</td>
                <td><input type="text" name="user_name" placeholder="请输入用户名"/></td>
            </tr>
            <tr>
                <td align="right">密码：</td>
                <td><input type="password" name="password" placeholder="请输入密码"/></td>
            </tr>
            <tr>
                <td>验证码：</td>
                <td><input type="text" name="code" placeholder="请输入验证码"/></td>
                <td>
                    <img src="code.php" alt="看不清楚，换一张" onclick="newgdcode(this,this.src)"/>
                </td>
            </tr>
            <tr>
                <td align="center"><input type="submit" name="submit" value="登录"/></td>
                <td align="center"><a href="register.php">立即注册</a></td>
            </tr>
        </table>
    </form>
<script language="javascript">
    function newgdcode(obj,url) {
        obj.src = url+ '?now_time=' + new Date().getTime();
    }
</script>
</body>
</html>