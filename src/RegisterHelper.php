<?php

include 'Connect.php';

function validRegister($username, $password, $repassword, $email, $conn) {
    $newpassword = md5($password."cathub");
    $sql = mysqli_query($conn, "select * from traveluser where UserName = '$username'");
    if (mysqli_fetch_array($sql)) {
        echo "<script>
            alert('Register Failed. Username Already Exists!');
            window.location.href='Register.php';
            </script>";
    }
    elseif ($password != $repassword) {
        echo "<script>
            alert('Register Failed. Password and Repassword are Different!');
            window.location.href='Register.php';
            </script>";
    }
    else {
        $sql1 = "INSERT INTO traveluser(UserName, Pass, Email) values('$username', '$newpassword', '$email')";
        mysqli_query($conn, $sql1);
        echo "<script>
            alert('Register Success, Please Login!');
            window.location.href='Login.php';
            </script>";
    }
}

$username = $_POST['username'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$email = $_POST['email'];
validRegister($username, $password, $repassword, $email, $conn);

?>