<html>
        <link href="../src/css/Register.css" rel="stylesheet" type="text/css">
    <head>
        <title>
            Sign up
        </title>
    </head>

    <div class="blank" style="position: relative;">
    <div class="back" style="position: relative;">
        <form name="RegisterForm" method="post" action="RegisterHelper.php">
            <img src="../img/cat.jpg" width=70px >
            <p>
                    Username<br><br>
                <input type="text" name="username" pattern="^([0-9a-zA-Z]|_)+$", minlength="2", maxlength="100", required>
            </p>
            <p>
                E-mail<br><br>
                <input type="email" name="email", pattern=/^([a-zA-Z]|[0-9])(\w|\-)+@([a-zA-Z0-9]|\.)+\.([a-zA-Z]{2,4})$/ required>
                </p>
            <p>
                Set your password<br><br>
            <input type="password" name="password", pattern="^([0-9a-zA-Z])+$", minlength="8", maxlength="100", required>
            </p>
            <p>
                Confirm your password<br><br>
                <input type="password" name="repassword", pattern="^([0-9a-zA-Z])+$", minlength="8", maxlength="100", required>
            </p>
            <p><br>
                <a href="../src/Login.html"><button>Sign up</button></a>
            </p>
        </form>

    </div class="content">
    </div>

    <div class="top" style="position: relative;">
        <p align="center">
            <br>
            Contact with us: jnlin16@fudan.edu.cn
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            All Rights Reversed
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Copyright 2019-2021 Web Fundamental
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CatHub
        </p>
    </div>
</html>