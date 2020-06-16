<html>
    <head>
        <title>Search</title>
    </head>
    <link href="./css/Search.css" rel="stylesheet" type="text/css">

    <div style="position:relative" class="ttop">
        <body>
            <div class="top">
                <center> 
                    <ul>
                    <img src="../img/cat.jpg" width="60" height="60" style="position:absolute; left:0px; top:0px; ">
                    <li><a href="./Home.php"><b>Home</b></a></li>
                    <li><a href="./Browser.php"><b>Browse</b></a></li>
                    <li><a href="./Search.php"><b><u>Search</u></b></a></li>
                
                    <?php include "Header.php" ?>      
                    </ul>
                    </center>      
            </div>
        </body>
    </div>

    <script>
        function display_alert(){
            alert("I am an alert box!!")
        }
    </script>

    <div class="content" style="position: relative;">
        <form method="get">
            <p style="position: absolute; left:57px; top: 10px;">Search</p>
            <input type="radio" value="Title" name="Search" style="position: absolute; left:50px; top: 80px;" required>
            <p style="position: absolute; left:80px; top: 62px;">Filter by Title</p>
            <input type="text" name="title" style="position: absolute; left:300px; top: 80px; width:70%">
            <input type="radio" value="Description" name="Search" style="position: absolute; left:50px; top: 140px;" required>
            <p style="position: absolute; left:80px; top: 122px;">Filter by Description</p>
            <textarea name="description" style="position: absolute; left:300px; top: 140px; width:70%; height: 120px;"></textarea>
            <button type="submit" style="position: absolute; left:60px; top:200px; width:120px; height:40px">Filter</button>
            <input type="hidden" name="pagenum" value="1" />
        </form>

        <p style="position: absolute; left:57px; top: 300px;">Result</p>

        <?php

            include "Connect.php";

            function Search_Title() {
                global $conn;
                global $title;
                $sql = "";
                if ($title == "") {
                    $sql = "SELECT ImageID FROM travelimage";
                    //echo "1";
                }
                else {
                    $sql = "SELECT ImageID FROM travelimage WHERE Title like '%$title%'";
                    //echo "2";
                }
                $check_query = mysqli_query($conn, $sql);
                $ImageID = array();
                while ($row = mysqli_fetch_array($check_query)) {
                    array_push($ImageID, $row['ImageID']);
                }
                //echo count($ImageID);
                return $ImageID;
            }

            function Search_Description() {
                global $conn;
                global $description;
                $sql = "";
                if ($description == "") {
                    $sql = "SELECT ImageID FROM travelimage";
                    //echo "1";
                }
                else {
                    $sql = "SELECT ImageID FROM travelimage WHERE Description like '%$description%'";
                    //echo "2";
                }
                $check_query = mysqli_query($conn, $sql);
                $ImageID = array();
                while ($row = mysqli_fetch_array($check_query)) {
                    array_push($ImageID, $row['ImageID']);
                }
                //echo count($ImageID);
                return $ImageID;
            }

            function ID2Path($ImageID) {
                global $conn;
                $ImagePath = array();
                for ($i = 0; $i < count($ImageID); $i++) {
                    $sql = "SELECT PATH FROM travelimage WHERE ImageID = $ImageID[$i]";
                    $check_query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($check_query);
                    array_push($ImagePath, $row['PATH']);
                }
                return $ImagePath;
            }

            function ID2Title($ImageID) {
                global $conn;
                $ImagePath = array();
                for ($i = 0; $i < count($ImageID); $i++) {
                    $sql = "SELECT Title FROM travelimage WHERE ImageID = $ImageID[$i]";
                    $check_query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($check_query);
                    array_push($ImagePath, $row['Title']);
                }
                return $ImagePath;
            }

            function ID2Decription($ImageID) {
                global $conn;
                $ImagePath = array();
                for ($i = 0; $i < count($ImageID); $i++) {
                    $sql = "SELECT `Description` FROM travelimage WHERE ImageID = $ImageID[$i]";
                    $check_query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($check_query);
                    array_push($ImagePath, $row['Description']);
                }
                return $ImagePath;
            }

            function changePagenum($url, $num) {
                $temp = explode('pagenum=', $url);
                if (count($temp) <= 1) {
                    return $url."pagenum=".$num;
                }
                else {
                    $temp1 = explode('&', $temp[1]);
                    if (count($temp1) < 1) {
                        return $temp[0]."pagenum=".$num;
                    }
                    else {
                        $result = $temp[0]."pagenum=".$num;
                        for ($i = 1; $i < count($temp1); $i++) {
                            $result = $result."&".$temp1[$i];
                        }
                        return $result;
                    }
                }
            }

            $title = empty($_GET['title']) ? "" : $_GET['title'];
            $description = empty($_GET['description']) ? "" : $_GET['description'];
            $Search = empty($_GET['Search']) ? "" : $_GET['Search'];
            $pagenum = empty($_GET['pagenum']) ? 1 : $_GET['pagenum'];

            $ImageID = array(1, 2, 3);
            if ($Search == "Title") {
                $ImageID = Search_Title();
            }
            elseif ($Search == "Description") {
                $ImageID = Search_Description();
            }

            $url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
            $ImagePath = ID2Path($ImageID);
            $ImageTitle = ID2Title($ImageID);
            $ImageDescription = ID2Decription($ImageID);

            $length = count($ImageID);
            //echo $length;
            $remain = $length - 3 * ($pagenum - 1);
            $times = 0;
            while ($times < 3 && $remain > 0) {
                echo '<a href="./Details.php?ImageID='.$ImageID[3 * ($pagenum - 1) + $times].
                '"><img src="../img/'.$ImagePath[3 * ($pagenum - 1) + $times].'" '.
                'width="200px" style = "position: absolute; left:50px; top:'.(400 + 300 * $times).
                'px"></a>';
                echo '<p style="position: absolute; left:350px; top:'.(400 + 300 * $times).
                'px;"<font size=5><b>'.$ImageTitle[3 * ($pagenum - 1) + $times].
                '</b></font></p>';
                echo '<p class="p2" style="position:absolute; left:350px; top:'.(450 + 300 * $times).
                'px;">'.$ImageDescription[3 * ($pagenum - 1) + $times].'</p>';
                $times++;
                $remain--;
            }

        ?>

        <p style="position: absolute; left:850px; bottom:30px;"><font color="blue">
        <?php
            //echo '1'.$url;
            $pagesize = floor(($length + 2) / 3);
            $pagesize = $pagesize > 5 ? 5 : $pagesize;
            $prev = $pagenum > 1 ? $pagenum - 1 : 1;
            $succ = $pagenum < $pagesize ? $pagenum + 1 : $pagesize;
            $url = changePagenum($url, $prev);
            echo "<a href='".$url."'><</a>";
            for ($i = 1; $i <= $pagesize; $i++) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                $url = changePagenum($url, $i);
                if ($i == $pagenum) {
                    echo "<a href='".$url."'><mark>".$i."</mark></a>";
                }
                else {
                    echo "<a href='".$url."'>".$i."</a>";
                }
            }
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            $url = changePagenum($url, $succ);
            echo "<a href='".$url."'>></a>";
            ?>
        </font></p>
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