<html>
    <head>
        <title>Upload</title>
    </head>
    <link href="./css/Upload.css" rel="stylesheet" type="text/css">

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

    $status = isset($_SESSION['username']) ? 1 : 0;
    $operation = isset($_GET['operation']) ? $_GET['operation'] : 0; // 0 means upload, 1 means modify
    $ImageID = empty($_GET['ImageID']) ? 1 : $_GET['ImageID'];
    if ($operation == 0) {
        $ImageID = -1;
    }
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
    $Path = $row["PATH"];

    ?>

    <div class="content" style="position: relative;">
        <img id="preview" style="position: absolute; left:40%; height:300px; top:50px" 
            <?php 
                if ($operation == 1) {
                    echo 'src="../img/'.$Path.'"';
                }
            ?>
        >
        <?php if ($status == 1) {
            echo'<form id="form" method="POST" enctype="multipart/form-data" 
            action="UploadHelper.php">'; }
        ?>
        <input type="file" accept="image/*" name="file" id="file" style="position: absolute; left:45%; width:200px; top:400px"/>  

        <p style="position: absolute; left:18%; top:450px">Title</p>
        <input type="text" name="Title" style="position: absolute; left:24%; width:60%; top:465px" 
            <?php
                if ($operation == 1) {
                    echo 'value="'.$Title.'"';
                }
            ?>
        >

        <p style="position: absolute; left:18%; top:500px">Country</p>
        <input type="text" name="Country" style="position: absolute; left:24%; width:60%; top:515px" 
            <?php
                if ($operation == 1) {
                    echo 'value="'.$Country.'"';
                }
            ?>
        >

        <p style="position: absolute; left:18%; top:550px">City</p>
        <input type="text" name="City" style="position: absolute; left:24%; width:60%; top:565px" 
            <?php
                if ($operation == 1) {
                    echo 'value="'.$City.'"';
                }
            ?>
        >

        <p style="position: absolute; left:18%; top:600px">Content</p>
        <select id="Content" name="Content" class="filter" style="position: absolute; left:24%; top:615px">
            <option id="C0" value="<?php 
                if ($operation == 0) {
                    echo 'Scenery';
                }
                else {
                    echo $Content;
                }
             ?>" selected>Select Content</option>
            <option id="C11" value="Scenery">Scenery</option>
            <option id="C12" value="City">City</option>
            <option id="C21" value="People">People</option>
            <option id="C22" value="Animal">Animal</option>
            <option id="C31" value="Building">Building</option>
            <option id="C32" value="Wonder">Wonder</option>
            <option id="C41" value="Other">Other</option>
        </select>

        <p style="position: absolute; left:18%; top:650px">Description</p>
        <textarea name="Description" style="position: absolute; left:24%; top: 665px; width:60%; height: 120px;"><?php
                if ($operation == 1) {
                    echo $Description;
                }
            ?></textarea>

        <input type="hidden" name="UID" value="<?php echo $UID; ?>"/>
        <input type="hidden" name="ImageID" value="<?php echo $ImageID; ?>"/>
        <input type="hidden" name="Path" value="<?php echo $Path; ?>"/>

        <?php
            if ($status == 0) {
                echo '<a href="./Login.php"><button style="position: absolute;
                left:47%; top:830px; width:120px; height:30px">Please Login</button></a>';
            }
            elseif ($operation == 0) {
                echo '<button type="submit" style="position: absolute;
                left:47%; top:830px; width:120px; height:30px">Upload</button>';
            }
            else {
                echo '<button type="submit" style="position: absolute;
                left:47%; top:830px; width:120px; height:30px">Modify</button>';
            }
        ?>
        <?php if ($status == 1) {
            echo '</form>';} 
        ?>

    </div>
       
    <script>
        function display_alert(){
            alert("I am an alert box!!")
        }
    </script>
            
    <script>
        var fileDom = document.getElementById("file");
        var previewDom = document.getElementById("preview");
        fileDom.addEventListener("change", e=>{
            var file = fileDom.files[0];
            // check if input contains a valid image file
            if (!file || file.type.indexOf("image/") < 0) {
                fileDom.value = "";
                previewDom.src = "";
                return;
            }
                
            // use FileReader to load image and show preview of the image
            var fileReader = new FileReader();
            fileReader.onload = e=>{
                previewDom.src = e.target.result;
            };
            fileReader.readAsDataURL(file);
        });
            
        var formDom = document.getElementById("form");
        function check() {
            var file = fileDom.files[0];
            // check if input contains a valid image file
            if (!file || file.type.indexOf("image/") < 0) {
                return false;
            }
            return true;
        }
        </script>

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