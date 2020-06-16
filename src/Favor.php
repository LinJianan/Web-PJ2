<html>
    <head>
        <title>Favor</title>
    </head>
    <link href="./css/Favor.css" rel="stylesheet" type="text/css">

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
    $username = $status == 1 ? $_SESSION['username'] : "JiananLin";
    $UID = getUID();

    $url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
    $pagenum = empty($_GET['pagenum']) ? 1 : intval($_GET['pagenum']);
    $delete = empty($_GET['delete']) ? 0 : intval($_GET['delete']);

    if ($delete != 0) {
        Delete();
    }

    $ImageID = getImageID();
    $ImagePath = ID2Path();
    $ImageTitle = ID2Title();
    $ImageDescription = ID2Description();

    $length = count($ImageID);
    //echo $length;
    $remain = $length - 3 * ($pagenum - 1);
    $times = 0;

    function Delete() {
        global $delete;
        global $UID;
        global $conn;
        if ($delete == 0) {
            return;
        }
        $sql = "DELETE FROM travelimagefavor WHERE UID = $UID and ImageID = $delete";
        $check_query = mysqli_query($conn, $sql);
        return;
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

    function changeDeletenum($url, $num) {
        $temp = explode('delete=', $url);
        if (count($temp) <= 1) {
            return $url."delete=".$num;
        }
        else {
            $temp1 = explode('&', $temp[1]);
            if (count($temp1) < 1) {
                return $temp[0]."delete=".$num;
            }
            else {
                $result = $temp[0]."delete=".$num;
                for ($i = 1; $i < count($temp1); $i++) {
                    $result = $result."&".$temp1[$i];
                }
                return $result;
            }
        }
    }

    function getUID() {
        global $conn;
        global $username;
        $sql = "SELECT * FROM traveluser WHERE UserName = '$username'";
        $check_query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($check_query);
        return $row['UID'];
    }

    function getImageID() {
        global $conn;
        global $username;
        global $UID;
        $ImageID = array();
        $sql = "SELECT DISTINCT ImageID FROM travelimagefavor WHERE UID = $UID";
        $check_query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($check_query)) {
            array_push($ImageID, $row['ImageID']);
        }
        $ImageID1 = array();
        for ($i = 0; $i < count($ImageID); $i++) {
            $temp = $ImageID[$i];
            $sql = "SELECT * FROM travelimage WHERE ImageID = $temp";
            $check_query = mysqli_query($conn, $sql);
            if ($row = mysqli_fetch_array($check_query)) {
                array_push($ImageID1, $temp);
            }
        }
        return $ImageID1;
    }

    function ID2Path() {
        global $conn;
        global $ImageID;
        $ImagePath = array();
        for ($i = 0; $i < count($ImageID); $i++) {
            $sql = "SELECT PATH FROM travelimage WHERE ImageID = $ImageID[$i]";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            array_push($ImagePath, $row['PATH']);
        }
        return $ImagePath;
    }

    function ID2Title() {
        global $conn;
        global $ImageID;
        $ImagePath = array();
        for ($i = 0; $i < count($ImageID); $i++) {
            $sql = "SELECT Title FROM travelimage WHERE ImageID = $ImageID[$i]";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            array_push($ImagePath, $row['Title']);
        }
        return $ImagePath;
    }

    function ID2Description() {
        global $conn;
        global $ImageID;
        $ImagePath = array();
        for ($i = 0; $i < count($ImageID); $i++) {
            $sql = "SELECT `Description` FROM travelimage WHERE ImageID = $ImageID[$i]";
            $check_query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($check_query);
            array_push($ImagePath, $row['Description']);
        }
        return $ImagePath;
    }

    ?>

    <div class="content" style="position: relative;">
        <p style="position: absolute; left:57px; top: 20px;">My Favor</p>

        <?php

        if ($status == 0) {
            echo '<a href="Login.php"><p style="position: absolute; 
            left:700px; top: 200px;">
            <font size=5>Please Login!</font></p><a>';
        }
        elseif ($length == 0) {
            echo '<p style="position: absolute; left:700px; top: 200px;">
            <font size=5>No Photo Now</font></p>';
        }
        else {
            while ($times < 3 && $remain > 0) {
                echo '<a href="./Details.php?ImageID='.$ImageID[3 * ($pagenum - 1) + $times].
                '"><img src="../img/'.$ImagePath[3 * ($pagenum - 1) + $times].
                '" width="200px" style="position: absolute; left:50px; top:'.
                (100 + 300 * $times).'px"></a>';

                echo '<p style="position: absolute; left:350px; top: '.
                (100 + 300 * $times).'px;"><font size=5><b>'.$ImageTitle[3 * ($pagenum - 1) + $times]
                .'</b></font></p>';

                echo '<p class="p2" style="position: absolute; left:350px; top: '.
                (150 + 300 * $times).'px;">'.$ImageDescription[3 * ($pagenum - 1) + $times].'</p>';

                $url1 = changeDeletenum($url, $ImageID[3 * ($pagenum - 1) + $times]);

                echo '<a href="'.$url1.'"><button style="
                position: absolute; left:350px; top: '.(250 + 300 * $times).
                'px; width:100px; height:30px;">Delete</button></a>';
                $times++;
                $remain--;
            }
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