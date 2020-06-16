<?php

include 'Connect.php';

function validLogin($username, $password, $conn) {
    $newpassword = md5($password."cathub");
    if (isset($_POST['username'])){
        $sql = "select * from traveluser where UserName='$username' and Pass='$newpassword' limit 1";
        $check_query = mysqli_query($conn,$sql);
        if( $row = $check_query->fetch_assoc()) {
            //登录成功
            session_start();
            $_SESSION['username'] = $row['UserName'];
            echo "<script>
            alert('Login Seccess!');
            window.location.href='Home.php';
            </script>";
        }
        else {
            // 登录失败
            echo "<script>
            alert('Login Fail, Username or Password False!');
            window.location.href='Login.php';
            </script>";
        }
    }
}

$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];
validLogin($username, $password, $conn);

?>