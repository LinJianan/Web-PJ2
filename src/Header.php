<?php

function show_tourist() {
    echo '
    <li style="position:absolute; right:0px">
        <a href="./Login.php"><b>Log in</b></a>
    </li>
    ';
}

function show_user() {
    echo '
    <li style="position:absolute; right:0px">
        <a href="#"><b>My Account</b></a>
        <ul>
            <li><a href="./Upload.php">Upload</a></li>
            <li><a href="./MyPhotos.php">My Photos</a></li>
            <li><a href="./Favor.php">My Favorite</a></li>
            <li><a href="./Logout.php">Log out</a></li>
        </ul>
    </li>
    ';
}

session_start();
if (isset($_SESSION['username'])){
    show_user();
}
else {
    show_tourist();
}

?>