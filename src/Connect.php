<?php
// 连接数据库用的
$conn = @mysqli_connect("localhost", "root", "", 'travel');
if (!$conn){
    die("连接数据库失败：" . mysqli_error());
}
mysqli_select_db($conn, "travel");
//字符转换，读库
mysqli_query($conn, "set names utf-8");
//写库
?>