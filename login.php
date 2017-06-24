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
    <title> 用户登录</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">用户登录</h3>
                </div>
                <div class="panel-body">
                    <form action="action.php?action=login_check" method="post" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="用户名" name="user_name" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="密码" name="password" type="password" value="">
                            </div>
                            <div class="form-group">
                                <input style="float: left;width: 60%" class="form-control" placeholder="验证码" name="code" type="text">
                                <img src="code.php"     onclick="newgdcode(this,this.src)"/>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">记住密码
                                    <a style="position: absolute;right: 0;top: -3px;" href="register.php" class="">还没有账户,立即注册</a>
                                </label>
                            </div>
                            <div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="登录"
                                       title=""/>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    function newgdcode(obj, url) {
        obj.src = url + '?now_time=' + new Date().getTime();
    }
</script>
</body>
</html>