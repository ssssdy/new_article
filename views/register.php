<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../static/css/style.css" rel="stylesheet" type="text/css" charset="utf-8">
    <title>用户注册页面</title>
</head>
<body>
<center>
    <h3>用户注册</h3>
    <form action="../controllers/action.php?action=regCheck" method="post">
        <table align="center" border="1">
            <tr>
                <td>用 户 名:</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>密 码:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>确认密码:</td>
                <td><input type="password" name="confirm"></td>
            </tr>
            <tr>
                <td>电 话:</td>
                <td><input type="text" name="phone"></td>
            </tr>
            <tr>
                <td>地 址:</td>
                <td><input type="text" name="address"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="注册"/></td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>