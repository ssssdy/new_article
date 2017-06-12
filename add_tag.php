<html>
<?php
session_start();
//echo $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='login.php'</script>";
}
?>
<head>
    <meta charset="utf-8">
    <title>文章管理系统</title>
</head>
<h3 align="center">文章分类添加</h3>
<body>
<form action="action.php?action=add_tag" method="post">
<table>
    <tr>
        <td>添加文章类别：</td>
        <td><input type="text" name="tag_name"></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>

</table>
</form>


</body>
</html>