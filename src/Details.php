<html>
        <link href="./css/Details.css" rel="stylesheet" type="text/css">
    <head>
            <title>Details</title>
    </head>
    <div style="position:relative" class="ttop">
        <body>
            <div class="top">
                <center> 
                <ul>
                    <img src="../img/cat.jpg" width="60" height="60" style="position:absolute; left:0px; top:0px; ">
                    <li><a href="./Home.php"><b>Home</b></a></li>
                    <li><a href="./Browser.php"><b>Browse</b></a></li>
                    <li><a href="./Search.php"><b>Search</b></a></li>
                    
                    <?php include "Header.php" ?>        
                </ul>
                </center>      
            </div>
        </body>
    </div>

    <?php

    include "Connect.php";

    $ImageID = empty($_GET['ImageID']) ? 1 : $_GET['ImageID'];
    //echo $ImageID;
    $status = isset($_SESSION['username']) ? 1 : 0;
    $username = $status == 1 ? $_SESSION['username'] : "JiananLin";
    $sql = "SELECT `UID` FROM traveluser WHERE UserName = '$username'";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    $UID = $row['UID'];

    $sql = "SELECT * FROM travelimage WHERE ImageID = $ImageID";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    $Title = $row['Title'];
    $Description = $row['Description'];
    $Content = $row['Content'];
    $Country = $row['CountryName'];
    $City = $row['CityName'];
    $AuthorID = $row['UID'];
    $Path = $row["PATH"];

    $sql = "SELECT UserName FROM traveluser WHERE UID = $AuthorID";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    $Author = $row['UserName'];

    $operation = empty($_GET['operation']) ? 0 : $_GET['operation'];
    if ($operation == 1) {
        $sql = "INSERT INTO travelimagefavor (UID, ImageID) values ($UID, $ImageID)";
        $check_query = mysqli_query($conn, $sql);
    }
    elseif ($operation == 2) {
        $sql = "DELETE FROM travelimagefavor WHERE UID = $UID and ImageID = $ImageID";
        $check_query = mysqli_query($conn, $sql);
    }

    $sql = "SELECT COUNT(*) FROM `travelimagefavor` WHERE ImageID = $ImageID";
    $check_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($check_query);
    $Number = $row['COUNT(*)'];

    $sql = "SELECT * FROM `travelimagefavor` WHERE ImageID = $ImageID and UID = $UID";
    $check_query = mysqli_query($conn, $sql);
    $Like = 0;
    if ($row = mysqli_fetch_array($check_query) && $status != 0) {
        $Like = 1;
    }

    

    ?>

    <div class="content" style="position: relative;">
        <div class="content1" style="position: relative;">
            <p style="line-height: 40px">&nbsp;&nbsp;&nbsp;&nbsp;Details</p>
        </div>
        <div class="content2" style="position: relative;">
            <img src="../img/<?php echo $Path; ?>" width=400px style="position:absolute;left:100px; top:130px">
            <p style="position: absolute; left:110px; bottom:130px">
                <font size=13><?php echo $Title; ?></font>
            </p>
            <p style="position: absolute; left:120px; bottom:100px">
                by <?php echo $Author; ?>
            </p>
            <p style="position: absolute; left:700px; top:150px">
                <font size=5>Content: <?php echo $Content; ?></font>
            </p>
            <p style="position: absolute; left:1000px; top:150px">
                <font size=5>Country: <?php echo $Country; ?></font>
            </p>
            <p style="position: absolute; left:700px; top:200px">
                <font size=5>City: <?php echo $City; ?></font>
            </p>
            <p style="position: absolute; left:1000px; top:200px">
                <font size=5 color="red">Like Number: <?php echo $Number; ?></font>
            </p>

            <?php 
                if ($status == 0) {
                    echo '<a href="Login.php">
                    <button style="position: absolute; left: 700px; top: 300px; 
                    height: 40px; width: 150px;"><font size=4>
                        Like<font></font></button></a>';
                }
                elseif ($Like == 0) {
                    echo '<form method="get">
                    <input type="hidden" name="ImageID" value="'.$ImageID.'"/>
                    <input type="hidden" name="operation" value="1" />
                    <button type="submit" style="position: absolute; left: 700px; top: 300px; 
                    height: 40px; width: 150px;"><font size=4>
                        Like<font></font></button><form>';
                }
                else {
                    echo '<form method="get">
                    <input type="hidden" name="ImageID" value="'.$ImageID.'"/>
                    <input type="hidden" name="operation" value="2" />
                    <button type="submit" style="position: absolute; left: 700px; top: 300px; 
                    height: 40px; width: 150px;"><font size=4>
                        Dislike<font></font></button><form>';
                }
             ?>
            
            
            <p style="position: absolute; left:700px; top:400px">
            <?php echo $Description; ?>
            </p>
        </div>
    </div>

    <div class="top" style="position: relative; margin-bottom: 0%">
        <p align="center"><font size="4">
            <br>
            Contact with us: jnlin16@fudan.edu.cn
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            All Rights Reversed
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Copyright 2019-2021 Web Fundamental
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            CatHub
        </font></p>
    </div>
</html>